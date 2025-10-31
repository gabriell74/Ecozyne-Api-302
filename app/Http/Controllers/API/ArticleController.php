<?php

namespace App\Http\Controllers\API;

use App\Models\Article;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $articles = Article::latest()->get()->map(function ($article) {
            $article->photo = asset('storage/' . $article->photo);
            return $article;
        });

        return response()->json([
            "success" => true,
            "message" => "Berhasil mengambil data artikel",
            "data" => $articles
        ], 200);
    }

    public function latestArticles()
    {
        $articles = Article::latest()->take(3)->get()->map(function ($article) {
            $article->photo = asset('storage/' . $article->photo);
            return $article;
        });

        return response()->json([
            "success" => true,
            "message" => "Berhasil mengambil data artikel",
            "data" => $articles
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(article $article)
    {
        
    }
}
