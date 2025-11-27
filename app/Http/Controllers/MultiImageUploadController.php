<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Image;

class MultiImageUploadController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'images'   => 'required|array',
            'images.*' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:5120',
        ]);

        $uploaded = [];

        foreach ($request->file('images') as $img) {
            $filename = uniqid() . '.' . $img->getClientOriginalExtension();
            $path = $img->storeAs('uploads', $filename, 'public');

            $image = Image::create([
                'filename' => $filename,
                'path'     => 'storage/' . $path,
            ]);

            $uploaded[] = [
                'id'  => $image->id,
                'url' => asset('storage/uploads/' . $filename),
            ];
        }

        return response()->json([
            'status'  => true,
            'message' => 'Images uploaded successfully!',
            'images'  => $uploaded,
        ], 201);
    }
}
