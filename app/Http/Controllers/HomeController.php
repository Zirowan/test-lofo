<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use App\Models\Student;
use App\Models\Item;

// Google Cloud Vision classes
use Google\Cloud\Vision\V1\ImageAnnotatorClient;
use Google\Cloud\Vision\V1\AnnotateImageRequest;
use Google\Cloud\Vision\V1\BatchAnnotateImagesRequest;
use Google\Cloud\Vision\V1\Image;
use Google\Cloud\Vision\V1\Feature;
use Google\Cloud\Vision\V1\Feature\Type as FeatureType;


class HomeController extends Controller
{
    /**
     * Show the student’s homepage with their lost & found items.
     */
    public function index($username)
    {
        \Log::info("DEBUG: HomeController@index called with username: " . $username);
        
        if (! Session::has('student')) {
            \Log::warning("DEBUG: No student session, redirecting to login");
            return redirect('/');
        }

        $student = Session::get('student');
        if (! $student || ! isset($student['email'])) {
            \Log::warning("DEBUG: Invalid student session, redirecting to login");
            return redirect('/')
                ->withErrors('Session expired or corrupted. Please log in again.');
        }
        
        \Log::info("DEBUG: Student session valid: " . $student['email']);

        $studentModel = Student::where('username', $username)->firstOrFail();

        $lostItems  = Item::where('type', 'lost')
                           ->where('from', $student['email'])
                           ->get();
        $foundItems = Item::where('type', 'found')
                           ->where('from', $student['email'])
                           ->get();

        // Combine lost and found items into one collection for the view
        $items = $foundItems->merge($lostItems);

        // Get ALL items for the map - show everything for now
        $allItems = Item::all(); // Get absolutely everything
        
        // Debug: Log what we have in database
        \Log::info("DEBUG: Total items in database: " . $allItems->count());
        
        // Log first few items directly
        if ($allItems->count() > 0) {
            foreach ($allItems->take(3) as $index => $item) {
                \Log::info("DEBUG: Item {$index} - ID: {$item->id}, Type: {$item->type}, Description: {$item->description}, Status: {$item->status}, Lat: " . ($item->latitude ?? 'NULL') . ", Lng: " . ($item->longitude ?? 'NULL'));
            }
        } else {
            \Log::warning("DEBUG: NO ITEMS FOUND IN DATABASE AT ALL!");
        }
        
        // Let's also check what statuses exist
        $statuses = Item::select('status')->distinct()->pluck('status')->toArray();
        \Log::info("DEBUG: Item statuses found: " . implode(', ', $statuses));
        
        \Log::info("DEBUG: Using ALL items count: " . $allItems->count());
        
        // Process items for map - show ALL items regardless of coordinates
        $mapItems = $allItems->map(function ($item) {
            $itemData = [
                'id' => $item->id,
                'description' => $item->description ?? 'No description',
                'type' => $item->type ?? 'unknown',
                'pic' => $item->pic ?? '',
                'created_at' => $item->created_at ? $item->created_at->toISOString() : null,
                'status' => $item->status ?? 'unknown',
                'latitude' => null,
                'longitude' => null,
                'has_default_location' => false
            ];
            
            // Always provide coordinates - use actual if available, default if not
            if (!is_null($item->latitude) && !is_null($item->longitude) 
                && $item->latitude != 0 && $item->longitude != 0
                && is_numeric($item->latitude) && is_numeric($item->longitude)) {
                $itemData['latitude'] = floatval($item->latitude);
                $itemData['longitude'] = floatval($item->longitude);
                $itemData['has_default_location'] = false;
            } else {
                // Use default campus location for items without coordinates
                $itemData['latitude'] = -6.9606152;
                $itemData['longitude'] = 109.6386821;
                $itemData['has_default_location'] = true;
            }
            
            return $itemData;
        })->toArray();
        
        // Debug final result
        \Log::info("DEBUG FINAL: Map items prepared: " . count($mapItems));
        if (count($mapItems) > 0) {
            \Log::info("DEBUG: First real item: " . json_encode($mapItems[0]));
            \Log::info("DEBUG: Total mapItems array count: " . count($mapItems));
            \Log::info("DEBUG: All mapItems data: " . json_encode(array_slice($mapItems, 0, 3))); // Log first 3 items
        } else {
            \Log::warning("NO ITEMS FOUND IN DATABASE - mapItems is empty!");
            \Log::info("This means there are no items in the items table to display on the map.");
        }

        \Log::info("DEBUG: About to return view with mapItems count: " . count($mapItems));
        \Log::info("DEBUG: mapItems data being sent to view: " . json_encode(array_slice($mapItems, 0, 2))); // Log first 2 items
        
        return view('home', compact(
            'studentModel',
            'lostItems',
            'foundItems',
            'mapItems',
            'items'
        ));
    }

    /**
     * Handle posting a new lost or found item.
     */
    public function add(Request $request, $username)
    {
        // Validate inputs, including coordinates
        $request->validate([
            'description' => 'required|string|max:255',
            'pic'         => 'required|image|mimes:png,jpg,jpeg,gif,webp|max:10240',
            'type'        => 'required|in:lost,found',
            'latitude'    => 'nullable|numeric',
            'longitude'   => 'nullable|numeric',
        ]);

        $student = Session::get('student');
        if (! $student) {
            return redirect('/')
                ->withErrors('Student session not found');
        }

        // Increment counter for the type (lost or found)
        $counterField = $request->type;
        $newCount = $student[$counterField] + 1;
        Student::where('email', $student['email'])
               ->update([$counterField => $newCount]);
        Session::put("student.{$counterField}", $newCount);

        // Store uploaded image
        $file     = $request->file('pic');
        $filename = "{$student['username']}-{$request->type}{$newCount}." . $file->getClientOriginalExtension();
        $file->move(public_path('images'), $filename);

        // Run image recognition with Google Vision API
        $imageLabels = $this->recognizeImage(public_path("images/{$filename}"));
        
        // Ensure $imageLabels is always an array
        if (!is_array($imageLabels)) {
            $imageLabels = [];
        }

        // Create new item using mass assignment with proper data validation
        $newItem = Item::create([
            'from' => $student['email'],
            'description' => $request->description,
            'pic' => $filename,
            'type' => $request->type,
            'status' => 'Unresolved',
            'image_labels' => $imageLabels, // Will be automatically cast to JSON
            'selected_label' => null,
            'latitude' => $request->latitude ? (float) $request->latitude : null,
            'longitude' => $request->longitude ? (float) $request->longitude : null,
        ]);

        $newItemId = $newItem->id;

        // Redirect back, flashing both the labels and the new item's ID
        return redirect()
            ->route('home.index', ['username' => $username])
            ->with([
                'image_labels' => $imageLabels, // Store as array, Laravel will handle serialization
                'last_item_id' => $newItemId,
            ]);
    }

    /**
     * Recognize image content using Google Vision API
     */
    private function recognizeImage(string $imagePath): array
{
    try {
        // Path to Google Cloud credentials
        $credentialsPath = storage_path('app/neon-essence-457316-i3-c0efd7d28aaa.json');
        
        // Check if credentials file exists
        if (!file_exists($credentialsPath)) {
            \Log::warning('Google Vision API credentials file not found: ' . $credentialsPath);
            return []; // Return empty array instead of throwing error
        }

        $client = new ImageAnnotatorClient([
            'credentials' => $credentialsPath,
        ]);

        $visionImage = (new Image())->setContent(file_get_contents($imagePath));
        $feature     = (new Feature())->setType(FeatureType::LABEL_DETECTION);

        $req = (new AnnotateImageRequest())
            ->setImage($visionImage)
            ->setFeatures([$feature]);

        $batchRes  = $client->batchAnnotateImages([$req]);
        $responses = $batchRes->getResponses();

        $labels = [];
        if (isset($responses[0])) {
            foreach ($responses[0]->getLabelAnnotations() as $label) {
                $labels[] = $label->getDescription();
            }
        }

        $client->close();
        return $labels;
        
    } catch (\Exception $e) {
        \Log::error('Google Vision API error: ' . $e->getMessage());
        return []; // Return empty array on error to prevent app crash
    }
}


    /**
     * Optional searchItems
     */
   public function searchItems(Request $request)
    {
    $searchTerm = strtolower($request->input('search'));

    $query = DB::table('items')
        ->whereRaw('LOWER(JSON_EXTRACT(range_tablets, "$")) LIKE ?', ['%' . $searchTerm . '%']);

    // Only exclude archived items for non-admins
    if (!session()->has('admin')) {
        $query->where('status', '!=', 'Archived');
    }

    $items = $query->get();

    return view('search-results', compact('items'));
    }

    /**
     * Update the selected_label (manual override) for a given item.
     */
    public function updateLabel(Request $request, $id)
    {
        $request->validate([
            'selected_label' => 'required|string|max:255',
        ]);

        $item = Item::findOrFail($id);
        $item->selected_label = $request->input('selected_label');
        $item->save();

        return back()->with('success', 'Label updated.');
    }
}
