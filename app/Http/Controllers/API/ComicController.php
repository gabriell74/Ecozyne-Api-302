<?php

namespace App\Http\Controllers\API;

use App\Models\Comic;
use Illuminate\Http\Request;

class ComicController extends Controller
{
    // 🔹 1. Ambil daftar semua komik (tanpa foto halaman)
    public function getAllComic()
    {
        $comics = Comic::select('id', 'comic_title', 'cover_photo', 'created_at', 'updated_at')->get();

        if ($comics->isEmpty()) {
            return response()->json([
                'message' => 'Belum ada komik yang tersedia'
            ], 404);
        }

        $mappedComics = $comics->map(function ($comic) {
            return [
                'id' => $comic->id,
                'title' => $comic->comic_title,
                'cover_photo' => asset('storage/' . $comic->cover_photo),
                'created_at' => $comic->created_at,
                'updated_at' => $comic->updated_at,
            ];
        });

        return response()->json([
            'message' => 'Daftar komik berhasil diambil',
            'data' => $mappedComics
        ], 200);
    }

    // 🔹 2. Ambil detail komik berdasarkan ID (termasuk foto halaman)
    public function getComicById($id)
    {
        $comic = Comic::with('comicPhotos')->find($id);

        if (!$comic) {
            return response()->json([
                'message' => 'Komik tidak ditemukan'
            ], 404);
        }

        $mappedComic = [
            'id' => $comic->id,
            'title' => $comic->comic_title,
            'cover_photo' => asset('storage/' . $comic->cover_photo),
            'photos' => $comic->comicPhotos->map(fn($photo) => asset('storage/' . $photo->photo)),
            'created_at' => $comic->created_at,
            'updated_at' => $comic->updated_at,
        ];

        return response()->json([
            'message' => 'Detail komik berhasil diambil',
            'data' => $mappedComic
        ], 200);
    }
}
