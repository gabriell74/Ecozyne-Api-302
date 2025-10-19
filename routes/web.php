<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\AdminRewardController;
use App\Http\Controllers\Admin\AdminArtikelController;

Route::get('/', [AdminAuthController::class, 'loginPage'])->name('login');
Route::post('/login/process', [AdminAuthController::class, 'login'])->name('login.process');

Route::middleware('auth')->group(function () {

    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

    // Kelola Artikel
    Route::get('/articles', [AdminArtikelController::class, 'index'])->name('article.list');
    Route::get('/article/create', [AdminArtikelController::class, 'create'])->name('article.create');
    Route::post('/article/store', [AdminArtikelController::class, 'store'])->name('article.store');
    Route::get('/article/details/{article}', [AdminArtikelController::class, 'show'])->name('article.show');
    Route::get('/article/edit/{article}', [AdminArtikelController::class, 'edit'])->name('article.edit');
    Route::put('article/update/{article}', [AdminArtikelController::class, 'update'])->name('article.update');
    Route::delete('/article/destroy/{article}', [AdminArtikelController::class, 'destroy'])->name('article.destroy');

    Route::get('/komunitas', [AdminController::class, 'komunitas'])->name('admin.komunitas.index');

    // Kelola Reward
    Route::get('/rewards', [AdminRewardController::class, 'index'])->name('reward.list');
    Route::get('/reward/create', [AdminRewardController::class, 'create'])->name('reward.create');
    Route::post('/reward/store', [AdminRewardController::class, 'store'])->name('reward.store');
    Route::get('/reward/details/{reward}', [AdminRewardController::class, 'show'])->name('reward.show');
    Route::get('/reward/edit/{reward}', [AdminRewardController::class, 'edit'])->name('reward.edit');
    Route::put('/reward/update/{reward}', [AdminRewardController::class, 'update'])->name('reward.update');
    Route::delete('/reward/destroy/{reward}', [AdminRewardController::class, 'destroy'])->name('reward.destroy');

    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');
});