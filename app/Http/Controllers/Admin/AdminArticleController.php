<?php

namespace App\Http\Controllers\Admin;

use App\Models\Article;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class AdminArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function getAllArticle()
    {
        $articles = Article::latest()->paginate(8); 

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
            'photo' => 'required|image|mimes:jpg,jpeg,png|max:8192',
            'description' => 'required|string',
        ]);

        $path = $request->file('photo')->store('articles', 'public');

        Article::create([
            'title' => $request->title,
            'photo' => $path,
            'description' => $request->description,
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
        return view('admin.article_edit', compact('article'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Article $article)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'description' => 'required|string',
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
        if ($article->photo && Storage::disk('public')->exists($article->photo)) {
            Storage::disk('public')->delete($article->photo);
        }

        $article->delete();

        return redirect()->route('article.list')->with('success', 'Berhasil menghapus artikel!');
    }
}
