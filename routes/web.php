<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminArtikelController;

Route::get("/", function () {
    return view("admin.dashboard");
});

Route::get('/article-list', [AdminArtikelController::class, 'index']);
Route::post('/create-article', [AdminArtikelController::class, 'store']);
