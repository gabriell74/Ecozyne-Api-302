<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\RegionController;
use App\Http\Controllers\API\ArticleController;
use App\Http\Controllers\API\GalleryController;
use App\Http\Controllers\Admin\AdminArtikelController;
use App\Http\Controllers\API\DiscussionQuestionController;

Route::post('/register', [UserController::class, 'register']);
Route::get('/regions', [RegionController::class, 'index']);

Route::post('/login', [AuthController::class, 'login']);

Route::get('/admin/gallery', [GalleryController::class, 'index']);

Route::get('/articles', [ArticleController::class, 'index']);
Route::get('/articles/latest', [ArticleController::class, 'latestArticles']);

Route::get('/questions', [DiscussionQuestionController::class, 'getAllQuestion']);

Route::middleware('auth:sanctum')->group(function () {
      Route::post('/logout', [AuthController::class, 'logout']);
      
      Route::post('/validate-password', [UserController::class, 'validatePassword']);
      
      Route::post('/question/store', [DiscussionQuestionController::class, 'storeQuestion']);
      Route::put('/question/update/{question}', [DiscussionQuestionController::class, 'updateQuestion']);
      Route::patch('/question/{question}/like', [DiscussionQuestionController::class, 'toggleLike']);
      Route::delete('/question/delete/{question}', [DiscussionQuestionController::class, 'deleteQuestion']);
});

/* 
* Semua Route dibawah ini nanti diubah ke web.php
*/

