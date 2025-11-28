<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\AdminComicController;
use App\Http\Controllers\Admin\AdminRewardController;
use App\Http\Controllers\Admin\AdminArticleController;
use App\Http\Controllers\Admin\AdminGalleryController;
use App\Http\Controllers\Admin\AdminActivityController;
use App\Http\Controllers\Admin\AdminExchangeRewardController;
use App\Http\Controllers\Admin\WasteBankSubmissionController;

Route::get('/', [AdminAuthController::class, 'loginPage'])->name('login');
Route::post('/login/process', [AdminAuthController::class, 'login'])->name('login.process');

Route::middleware('auth_admin')->group(function () {

    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    
    // Kelola Profil
    Route::get('/profile', [AdminController::class, 'profile'])->name('admin.profile');
    Route::put('profile/update', [AdminController::class, 'updateProfile'])->name('admin.profile_update');
        
    // Kelola Pengguna (Komunitas)
    Route::get('/communities', [AdminUserController::class, 'getAllCommunity'])->name('community.list');
    Route::delete('/community/destroy/{community}', [AdminUserController::class, 'destroyCommunity'])->name('community.destroy');

    // Kelola Pengguna (Bank Sampah)
    Route::get('/waste_banks', [AdminUserController::class, 'getAllWasteBank'])->name('waste_bank.list');
    Route::delete('/waste_bank/destroy/{waste_bank}', [AdminUserController::class, 'destroyWasteBank'])->name('waste_bank.destroy');

    // Kelola Artikel
    Route::get('/articles', [AdminArticleController::class, 'getAllArticle'])->name('article.list');
    Route::get('/article/create', [AdminArticleController::class, 'create'])->name('article.create');
    Route::post('/article/store', [AdminArticleController::class, 'store'])->name('article.store');
    Route::get('/article/details/{article}', [AdminArticleController::class, 'show'])->name('article.show');
    Route::get('/article/edit/{article}', [AdminArticleController::class, 'edit'])->name('article.edit');
    Route::put('article/update/{article}', [AdminArticleController::class, 'update'])->name('article.update');
    Route::delete('/article/destroy/{article}', [AdminArticleController::class, 'destroy'])->name('article.destroy');

    // Kelola Komik
    Route::get('/comics', [AdminComicController::class, 'getAllComic'])->name('comic.list');
    Route::get('/comic/create', [AdminComicController::class, 'create'])->name('comic.create');
    Route::post('/comic/store', [AdminComicController::class, 'store'])->name('comic.store');
    Route::get('/comic/details/{comic}', [AdminComicController::class, 'show'])->name('comic.show');
    Route::delete('/comic/destroy/{comic}', [AdminComicController::class, 'destroy'])->name('comic.destroy');

    // Kelola Kegiatan Sosial
    Route::get('/activities', [AdminActivityController::class, 'getAllActivity'])->name('activity.list');
    Route::get('/activity/create', [AdminActivityController::class, 'create'])->name('activity.create');
    Route::post('/activity/store', [AdminActivityController::class, 'store'])->name('activity.store');
    Route::get('/activity/details/{activity}', [AdminActivityController::class, 'show'])->name('activity.show');
    Route::get('/activity/edit/{activity}', [AdminActivityController::class, 'edit'])->name('activity.edit');
    Route::put('activity/update/{activity}', [AdminActivityController::class, 'update'])->name('activity.update');
    Route::delete('/activity/destroy/{activity}', [AdminActivityController::class, 'destroy'])->name('activity.destroy');

    // Kelola Hadiah
    Route::get('/rewards', [AdminRewardController::class, 'getAllReward'])->name('reward.list');
    Route::get('/reward/create', [AdminRewardController::class, 'create'])->name('reward.create');
    Route::post('/reward/store', [AdminRewardController::class, 'store'])->name('reward.store');
    Route::get('/reward/details/{reward}', [AdminRewardController::class, 'show'])->name('reward.show');
    Route::get('/reward/edit/{reward}', [AdminRewardController::class, 'edit'])->name('reward.edit');
    Route::put('/reward/update/{reward}', [AdminRewardController::class, 'update'])->name('reward.update');
    Route::delete('/reward/destroy/{reward}', [AdminRewardController::class, 'destroy'])->name('reward.destroy');

    // Kelola Hadiah
    Route::get('/galleries', [AdminGalleryController::class, 'getAllGallery'])->name('gallery.list');
    Route::get('/gallery/create', [AdminGalleryController::class, 'create'])->name('gallery.create');
    Route::post('/gallery/store', [AdminGalleryController::class, 'store'])->name('gallery.store');
    Route::get('/gallery/details/{gallery}', [AdminGalleryController::class, 'show'])->name('gallery.show');
    Route::get('/gallery/edit/{gallery}', [AdminGalleryController::class, 'edit'])->name('gallery.edit');
    Route::put('/gallery/update/{gallery}', [AdminGalleryController::class, 'update'])->name('gallery.update');
    Route::delete('/gallery/destroy/{gallery}', [AdminGalleryController::class, 'destroy'])->name('gallery.destroy');

    // Konfirmasi Bank Sampah
    Route::get('/confir', [WasteBankSubmissionController::class, 'confirBank'])->name('admin.confir_bank');
    Route::get('/confir/{id}', [WasteBankSubmissionController::class, 'show'])->name('bank_sampah.show');

    // Konfirmasi Penukaran Hadiah
    Route::get('/exchange_reward', [AdminExchangeRewardController::class, 'getAllExchangeReward'])->name('admin.exchange_reward_list');
    Route::put('/exchange_reward/approval/{exchange}', [AdminExchangeRewardController::class, 'rewardExchangeApproval'])->name('admin.exchange_reward_approval');

    // Logout
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');
});