<?php

namespace App\Http\Controllers\Admin;

use App\Models\Gallery;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class AdminGalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function getAllGallery()
    {
        $galleries = Gallery::latest()->paginate(8); 

        return view('admin.gallery_list', compact('galleries'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.gallery_create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'photo' => 'required|image|mimes:jpg,jpeg,png|max:8192',
            'description' => 'required|string',
        ]);

        $path = $request->file('photo')->store('gallery', 'public');

        Gallery::create([
            'photo' => $path,
            'description' => $request->description,
        ]);

        return redirect()->route('gallery.list')->with('success', 'Berhasil menambah foto!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Gallery $gallery)
    {
        return view('admin.gallery_detail', compact('gallery'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Gallery $gallery)
    {
        return view('admin.gallery_edit', compact('gallery'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Gallery $gallery)
    {
        $request->validate([
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:8192',
            'description' => 'required|string',
        ]);

        $gallery->description = $request->description;

        if ($request->hasFile('photo')) {
            if ($gallery->photo) {
                Storage::delete('public/' . $gallery->photo);
            }

            $path = $request->file('photo')->store('gallery', 'public');
            $gallery->photo = $path;
        }

        $gallery->save();

        return redirect()->route('gallery.list')->with('success', 'Berhasil mengubah foto!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Gallery $gallery)
    {
        if ($gallery->photo && Storage::disk('public')->exists($gallery->photo)) {
            Storage::disk('public')->delete($gallery->photo);
        }

        $gallery->delete();

        return redirect()->route('gallery.list')->with('success', 'Berhasil menghapus foto!');
    }
}
