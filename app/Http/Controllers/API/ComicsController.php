<?php

namespace App\Http\Controllers\API;

use App\Models\Comic;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ComicsController extends Controller
{
    public function getAllComics()
    {
        $comics = Comic::with('comicPhotos')->get()->map(function ($comic) {

            $comic->cover_photo = $comic->cover_photo
                ? asset('storage/' . $comic->cover_photo)
                : null;

            $comic->comicPhotos = $comic->comicPhotos->map(function ($photo) {
                $photo->photo = asset('storage/' . $photo->photo);
                return $photo;
            });

            return $comic;
        });

        return response()->json([
            'success' => true,
            'message' => 'Berhasil mengambil data komik',
            'data' => $comics,
        ], 200);
    }
}
