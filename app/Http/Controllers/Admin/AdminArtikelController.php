<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\Http\Request;

class AdminArtikelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $articles = Article::latest()->get(); 

        return view('admin.article_list', compact('articles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.article_create');
    }

    /**
     * Store a newly created resource in storage.
     */
        public function store(Request $request)
        {
            $request->validate([
                'title' => 'required',
                'description' => 'required',
                'photo' => 'required|image|mimes:jpg,jpeg,png|max:8192',
            ]);

            $path = $request->file('photo')->store('articles', 'public');

            Article::create([
                'title' => $request->title,
                'description' => $request->description,
                'photo' => $path,
            ]);

            return redirect()->route('article.list')->with('success', 'Berhasil menambah artikel!');
        }

    /**
     * Display the specified resource.
     */
    public function show(Article $article)
    {
        return view('admin.article_detail', compact('article'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
