<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use Google\Cloud\Vision\V1\ImageAnnotatorClient;
use Google\Cloud\Core\ServiceBuilder;

class ImageRecognitionController extends Controller
{
    public function recognize(Request $request)
    {
        $request->validate([
            'image' => 'required|image|max:5120',
        ]);

        $path = $request->file('image')->store('uploads', 'public');
        $imagePath = storage_path("app/public/{$path}");

        try {
            // Path to Google Cloud credentials
            $credentialsPath = storage_path('app/neon-essence-457316-i3-c0efd7d28aaa.json');
            
            // Check if credentials file exists
            if (!file_exists($credentialsPath)) {
                \Log::warning('Google Vision API credentials file not found: ' . $credentialsPath);
                return view('image.result', [
                    'labels' => [],
                    'image' => $path
                ]);
            }

            putenv('GOOGLE_APPLICATION_CREDENTIALS=' . $credentialsPath);

            // Create client instance
            $imageAnnotator = new ImageAnnotatorClient([
                'credentials' => $credentialsPath,
            ]);

            $image = file_get_contents($imagePath);
            $response = $imageAnnotator->labelDetection($image);
            $labels = $response->getLabelAnnotations();
            $imageAnnotator->close();

            $results = [];
            if ($labels) {
                foreach ($labels as $label) {
                    $results[] = $label->getDescription();
                }
            }

            return view('image.result', [
                'labels' => $results,
                'image' => $path
            ]);
            
        } catch (\Exception $e) {
            \Log::error('Google Vision API error in recognize: ' . $e->getMessage());
            return view('image.result', [
                'labels' => [],
                'image' => $path
            ]);
        }
    }

    public function searchByImage(Request $request)
    {
        $request->validate([
            'vision_image' => 'required|image|max:5120',
        ]);

        $path = $request->file('vision_image')->store('uploads', 'public');
        $imagePath = storage_path("app/public/{$path}");

        try {
            // Path to Google Cloud credentials
            $credentialsPath = storage_path('app/neon-essence-457316-i3-c0efd7d28aaa.json');
            
            // Check if credentials file exists
            if (!file_exists($credentialsPath)) {
                \Log::warning('Google Vision API credentials file not found: ' . $credentialsPath);
                return view('search-results', [
                    'items' => collect(),
                    'labels' => [],
                    'uploadedImage' => $path
                ]);
            }

            putenv('GOOGLE_APPLICATION_CREDENTIALS=' . $credentialsPath);

            $imageAnnotator = new ImageAnnotatorClient([
                'credentials' => $credentialsPath,
            ]);

            $image = file_get_contents($imagePath);
            $response = $imageAnnotator->labelDetection($image);
            $labels = $response->getLabelAnnotations();
            $imageAnnotator->close();

            $results = [];
            if ($labels) {
                foreach ($labels as $label) {
                    $results[] = strtolower($label->getDescription());
                }
            }

            $items = Item::where('status', '!=', 'Archived')
                ->where(function ($query) use ($results) {
                    foreach ($results as $label) {
                        $query->orWhereRaw('LOWER(image_labels) LIKE ?', ["%$label%"]);
                    }
                })
                ->get();

            return view('search-results', [
                'items' => $items,
                'labels' => $results,
                'uploadedImage' => $path
            ]);
            
        } catch (\Exception $e) {
            \Log::error('Google Vision API error in searchByImage: ' . $e->getMessage());
            return view('search-results', [
                'items' => collect(),
                'labels' => [],
                'uploadedImage' => $path
            ]);
        }
    }
}
