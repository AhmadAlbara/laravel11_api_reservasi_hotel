<?php

namespace App\Http\Controllers;

use App\Models\Photo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PhotoController extends Controller
{

    public function store(Request $request)
    {
        $request->validate([
            'hotel_id' => 'required|exists:hotels,id',
            'photo' => 'required|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            $photoPath = $photo->store('photos', 'public');  // Menyimpan foto di storage/app/public/photos

            // Simpan ke database
            $newPhoto = Photo::create([
                'hotel_id' => $request->hotel_id,  // Mengaitkan foto dengan hotel
                'photo_path' => $photoPath,
            ]);

            return response()->json([
                'message' => 'Photo uploaded successfully!',
                'photo' => $newPhoto
            ], 201);
        }

        return response()->json([
            'message' => 'No photo uploaded'
        ], 400);
    }

    public function destroy($id)
    {
        $photo = Photo::findOrFail($id);

        // Menghapus file foto dari storage
        if (Storage::disk('public')->exists($photo->photo_path)) {
            Storage::disk('public')->delete($photo->photo_path);
        } else {
            return response()->json(['message' => 'Photo file not found'], 404);
        }

        // Menghapus entri foto dari database
        $photo->delete();

        return response()->json(['message' => 'Photo deleted successfully!'], 204);
    }
}
