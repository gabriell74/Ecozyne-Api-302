<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminArtikelController;
use App\Http\Controllers\Admin\AdminController;

Route::get("/", function () {
    return view("admin.dashboard");
})->name('admin.dashboard');

Route::get('/articles', [AdminArtikelController::class, 'index'])->name('article.list');
Route::get('/article/details/{article}', [AdminArtikelController::class, 'show'])->name('article.show');
Route::get('/article/create', [AdminArtikelController::class, 'create'])->name('article.create');
Route::post('/article/store', [AdminArtikelController::class, 'store'])->name('article.store');
Route::delete('/article/destroy/{article}', [AdminArtikelController::class, 'destroy'])->name('article.destroy');
Route::get('/article/edit/{article}', [AdminArtikelController::class, 'edit'])->name('article.edit');
Route::put('article/update/{article}', [AdminArtikelController::class, 'update'])->name('article.update');
Route::get('/komunitas', [AdminController::class, 'komunitas'])->name('admin.komunitas.index');