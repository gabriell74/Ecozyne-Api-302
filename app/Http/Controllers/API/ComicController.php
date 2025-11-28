<?php

namespace App\Http\Controllers\API;

use App\Models\Comic;
use App\Models\ComicPhoto;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ComicController extends Controller
{
    public function getAllComics()
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
            'success' => true,
            'message' => 'Daftar komik berhasil diambil',
            'data' => $mappedComics
        ], 200);
    }

    public function getComicById($id)
    {
        $photos = ComicPhoto::where('comic_id', $id)
            ->orderBy('comic_page', 'asc')
            ->get(['id', 'comic_page', 'photo']);

        if ($photos->isEmpty()) {
            return response()->json([
                'message' => 'Foto komik tidak ditemukan',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Foto komik berhasil diambil',
            'data' => [
                'comic_id' => $id,
                'photos' => $photos->map(fn($p) => asset('storage/' . $p->photo)),
            ]
        ], 200);
    }
}
