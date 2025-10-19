<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\File;
use App\Models\Item;
use App\Models\Student;
use Illuminate\Http\Request;

class PicviewController extends Controller
{
    public function index()
    {
        // Check if the student is in the session
        if (!session('student')) {
            return redirect('/');
        }

        // Get the current path and extract the picture name
        $path = url()->current();
        $path_split = explode('/', $path);
        $pic_name = end($path_split);
        
        // Find the item by picture name
        $item = Item::where('pic', $pic_name)->first();

        // If the picture does not exist, redirect back with error
        if (!$item) {
            return redirect('/home/' . session('student')['username'])->withErrors(['Item tidak ditemukan']);
        }

        // Get the reporter's information
        $reporter = Student::where('email', $item->from)->first();

        // Store the selected item in the session
        session()->put('pic', $item);

        // Pass only the necessary data to the view
        return view('pic_view', compact('item', 'reporter'));
    }

    public function delete()
    {
        // Check if the student is in the session
        if (!session('student')) {
            return redirect('/');
        }

        // Get the current path and extract the picture name
        $path = url()->current();
        $path_split = explode('/', $path);
        $pic_name = end($path_split);

        // First, get the item to check ownership
        $item = Item::where('pic', $pic_name)->first();

        // If the item is not found, redirect back
        if (!$item) {
            return redirect('/home/' . session('student')['username'])->withErrors(['Item tidak ditemukan']);
        }

        // Check if the current user is the owner of the item
        if (session('student')['email'] !== $item->from) {
            return redirect('/home/' . session('student')['username'])->withErrors(['Anda tidak berhak menghapus item ini']);
        }

        // Delete the item from database
        $deleted = $item->delete();

        // Delete the picture file from the disk if it exists
        $imagePath = public_path('images/' . $pic_name);
        if (File::exists($imagePath)) {
            File::delete($imagePath);
        }

        // Redirect back to the student's homepage
        return redirect('/home/' . session('student')['username'])->with('success', 'Item berhasil dihapus');
    }
}
