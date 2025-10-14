<?php

namespace App\Http\Controllers\Admin;

use App\Models\Article;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

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
    public function edit(Article $article)
    {
        return view('admin.article_edit', compact("article"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Article $article)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $article->title = $request->title;
        $article->description = $request->description;

        if ($request->hasFile('photo')) {
            if ($article->photo) {
                Storage::delete('public/' . $article->photo);
            }

            $path = $request->file('photo')->store('articles', 'public');
            $article->photo = $path;
        }

        $article->save();

        return redirect()->route('article.list')->with('success', 'Artikel berhasil diperbarui!');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Article $article)
    {
        $article->delete();

        return redirect()->route('article.list')->with('success', 'Berhasil menghapus artikel!');
    }
}
