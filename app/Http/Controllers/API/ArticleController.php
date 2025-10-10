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
        return response()->json([
            "success" => true,
            "data" => Article::latest()->get()
        ]);

    }

    /**
     * Display the specified resource.
     */
    public function show(article $article)
    {
        //
    }
}
