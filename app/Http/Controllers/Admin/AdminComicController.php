<?php

namespace App\Http\Controllers\Admin;

use App\Models\Comic;
use App\Models\ComicPhoto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Laravel\Facades\Image;

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
            'photo'       => 'required|array|min:1',
            'photo.*'     => 'required|image|mimes:jpg,jpeg,png|max:8192',
        ]);

        try {
            DB::beginTransaction();

           
            $coverFile = $request->file('cover_photo');

            $coverImage = Image::read($coverFile)
                ->scaleDown(width: 1080)
                ->toJpeg(75);

            $coverFileName = 'comic/' . uniqid() . '.jpg';
            Storage::disk('public')->put($coverFileName, $coverImage);

            $comic = Comic::create([
                'comic_title' => $request->comic_title,
                'cover_photo' => $coverFileName,
            ]);

            
            if ($request->hasFile('photo')) {
                $pageNumber = 1;

                foreach ($request->file('photo') as $file) {

                    $img = Image::read($file)
                        ->scaleDown(width: 1080)
                        ->toJpeg(75);

                    $pageFileName = 'comic/comic_pages/' . uniqid() . '.jpg';
                    Storage::disk('public')->put($pageFileName, $img);

                    $comic->comicPhotos()->create([
                        'comic_page' => $pageNumber,
                        'photo'      => $pageFileName,
                    ]);

                    $pageNumber++;
                }
            }

            DB::commit();

            return redirect()->route('comic.list')
                ->with('success', 'Berhasil menambah komik!');

        } catch (\Exception $e) {
            DB::rollBack();
            dd($e->getMessage());
            return redirect()->route('comic.list')
                ->with('fail', 'Gagal menambah komik!');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Comic $comic)
    {
        $comic_photos = ComicPhoto::where('comic_id', $comic->id)
            ->orderBy('comic_page', 'asc')
            ->get();

        return view('admin.comic_detail', compact('comic', 'comic_photos'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Comic $comic)
    {
        return view('admin.comic_edit', compact('comic'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Comic $comic)
    {
        $request->validate([
            'comic_title' => 'required',
            'cover_photo' => 'nullable|image|mimes:jpg,jpeg,png|max:8192',
        ]);

        $comic->comic_title = $request->comic_title;

        if ($request->hasFile('cover_photo')) {

            if ($comic->cover_photo) {
                Storage::disk('public')->delete($comic->cover_photo);
            }

            $file = $request->file('cover_photo');

            $img = Image::read($file)
                ->scaleDown(width: 1080)
                ->toJpeg(75);

            $path = 'comic/' . uniqid() . '.jpg';

            Storage::disk('public')->put($path, $img);

            $comic->cover_photo = $path;
        }

        $comic->save();

        return redirect()->route('comic.list')
            ->with('success', 'Komik berhasil diperbarui!');
    }

    public function editComicPhoto(ComicPhoto $comic_photo)
    {
        return view('admin.comic_photo_edit', compact('comic_photo'));
    }

    public function updateComicPhoto(Request $request, ComicPhoto $comic_photo)
    {
        $request->validate([
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:8192',
        ]);

        if (!$request->hasFile('photo')) {
            return redirect()
                ->route('comic.show', $comic_photo->comic_id)
                ->with('success', 'Komik berhasil diperbarui');
        }

        if ($comic_photo->photo) {
            Storage::disk('public')->delete($comic_photo->photo);
        }

        $file = $request->file('photo');

        $compressed = Image::read($file)
            ->scaleDown(width: 1080)
            ->toJpeg(75);

        $path = 'comic/comic_pages/' . uniqid() . '.jpg';
        Storage::disk('public')->put($path, $compressed);

        $comic_photo->photo = $path;
        $comic_photo->save();

        return redirect()
            ->route('comic.show', $comic_photo->comic_id)
            ->with('success', 'Komik berhasil diperbarui!');
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
            return redirect()->route('comic.list')->with('error', 'Gagal menghapus komik, silahkan coba lagi');
        }
    }
}
