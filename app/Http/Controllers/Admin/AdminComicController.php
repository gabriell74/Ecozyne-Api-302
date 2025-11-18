<?php

namespace App\Http\Controllers\Admin;

use App\Models\Comic;
use App\Models\ComicPhoto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class AdminComicController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function getAllComic()
    {
        $comics = Comic::latest()->paginate(8); 

        return view('admin.comic_list', compact('comics'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.comic_create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'comic_title' => 'required',
            'cover_photo' => 'required|image|mimes:jpg,jpeg,png|max:8192',
            'photo' => 'required|array|min:1',
            'photo.*' => 'required|image|mimes:jpg,jpeg,png|max:8192',
        ]);

        try {
            $cover_path = $request->file('cover_photo')->store('comic', 'public');
            DB::beginTransaction();
            
            $comic = Comic::create([
                'comic_title' => $request->comic_title,
                'cover_photo' => $cover_path,
            ]);

            if ($request->hasFile('photo')) {
                $pageNumber = 1;

                foreach ($request->file('photo') as $file) {
                    $pageFileName = $file->store('comic/comic_pages', 'public');

                    $comic->comicPhotos()->create([
                        'comic_page' => $pageNumber,
                        'photo' => $pageFileName,
                    ]);

                    $pageNumber++;
                }
            }

            DB::commit();

            return redirect()->route('comic.list')->with('success', 'Berhasil menambah komik!');

        } catch (\Exception $e) {
            DB::rollback();
            dd($e->getMessage());
            return redirect()->route('comic.list')->with('fail', 'Gagal menambah komik!');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Comic $comic)
    {
        $comic_photos = ComicPhoto::where('comic_id', $comic->id)->orderBy('comic_page', 'asc')->get();
        return view('admin.comic_detail', compact('comic', 'comic_photos'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comic $comic)
    {
        try {
            DB::beginTransaction();
    
            foreach ($comic->comicPhotos as $photo) {
                if ($photo->photo && Storage::disk('public')->exists($photo->photo)) {
                    Storage::disk('public')->delete($photo->photo);
                }
            }

            if ($comic->cover_photo && Storage::disk('public')->exists($comic->cover_photo)) {
                Storage::disk('public')->delete($comic->cover_photo);
            }
            
            $comic->comicPhotos()->delete();
            $comic->delete();
            DB::commit();

            return redirect()->route('comic.list')->with('success', 'Berhasil menghapus komik!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('comics.list')->with('error', 'Gagal menghapus komik, silahkan coba lagi');
        }

    }
}
