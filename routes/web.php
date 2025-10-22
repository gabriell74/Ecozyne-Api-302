<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\AdminRewardController;
use App\Http\Controllers\Admin\AdminArticleController;
use App\Http\Controllers\Admin\AdminActivityController;

Route::get('/', [AdminAuthController::class, 'loginPage'])->name('login');
Route::post('/login/process', [AdminAuthController::class, 'login'])->name('login.process');

Route::middleware('auth')->group(function () {

    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

    //kelola pengguna
    Route::get('/komunitas', function () {return view('admin.komunitas');})->name('admin.komunitas');
    Route::get('/wastebank', function () {return view('admin.wastebank');})->name('admin.wastebank');

    // Kelola Artikel
    Route::get('/articles', [AdminArticleController::class, 'getAllArticle'])->name('article.list');
    Route::get('/article/create', [AdminArticleController::class, 'create'])->name('article.create');
    Route::post('/article/store', [AdminArticleController::class, 'store'])->name('article.store');
    Route::get('/article/details/{article}', [AdminArticleController::class, 'show'])->name('article.show');
    Route::get('/article/edit/{article}', [AdminArticleController::class, 'edit'])->name('article.edit');
    Route::put('article/update/{article}', [AdminArticleController::class, 'update'])->name('article.update');
    Route::delete('/article/destroy/{article}', [AdminArticleController::class, 'destroy'])->name('article.destroy');

    // Kelola Kegiatan Sosial
    Route::get('/activities', [AdminActivityController::class, 'getAllActivity'])->name('activity.list');
    Route::get('/activity/create', [AdminActivityController::class, 'create'])->name('activity.create');
    Route::post('/activity/store', [AdminActivityController::class, 'store'])->name('activity.store');
    Route::get('/activity/details/{activity}', [AdminActivityController::class, 'show'])->name('activity.show');
    Route::get('/activity/edit/{activity}', [AdminActivityController::class, 'edit'])->name('activity.edit');
    Route::put('activity/update/{activity}', [AdminActivityController::class, 'update'])->name('activity.update');
    Route::delete('/activity/destroy/{activity}', [AdminActivityController::class, 'destroy'])->name('activity.destroy');

    // Kelola Reward
    Route::get('/rewards', [AdminRewardController::class, 'getAllReward'])->name('reward.list');
    Route::get('/reward/create', [AdminRewardController::class, 'create'])->name('reward.create');
    Route::post('/reward/store', [AdminRewardController::class, 'store'])->name('reward.store');
    Route::get('/reward/details/{reward}', [AdminRewardController::class, 'show'])->name('reward.show');
    Route::get('/reward/edit/{reward}', [AdminRewardController::class, 'edit'])->name('reward.edit');
    Route::put('/reward/update/{reward}', [AdminRewardController::class, 'update'])->name('reward.update');
    Route::delete('/reward/destroy/{reward}', [AdminRewardController::class, 'destroy'])->name('reward.destroy');

    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');
});