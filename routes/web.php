<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminArtikelController;

Route::get("/", function () {
    return view("admin.dashboard");
});

Route::get('/articles', [AdminArtikelController::class, 'index'])->name('article.list');
Route::get('/article/details/{article}', [AdminArtikelController::class, 'show'])->name('article.show');
Route::get('/article/create', [AdminArtikelController::class, 'create'])->name('article.create');
Route::post('/article/store', [AdminArtikelController::class, 'store'])->name('article.store');
