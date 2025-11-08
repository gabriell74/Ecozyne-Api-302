<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\RegionController;
use App\Http\Controllers\API\ArticleController;
use App\Http\Controllers\API\GalleryController;
use App\Http\Controllers\API\DiscussionAnswerController;
use App\Http\Controllers\API\DiscussionQuestionController;

Route::post('/register', [UserController::class, 'register']);
Route::get('/regions', [RegionController::class, 'index']);

Route::post('/login', [AuthController::class, 'login']);

Route::get('/admin/gallery', [GalleryController::class, 'index']);

Route::get('/articles', [ArticleController::class, 'index']);
Route::get('/articles/latest', [ArticleController::class, 'latestArticles']);

Route::get('/questions', [DiscussionQuestionController::class, 'getAllQuestion']);

Route::get('/answers', [DiscussionAnswerController::class, 'getAllAnswer']);

Route::middleware('auth:sanctum')->group(function () {
      Route::post('/logout', [AuthController::class, 'logout']);
      
      Route::post('/validate-password', [UserController::class, 'validatePassword']);
      
      Route::post('/question/store', [DiscussionQuestionController::class, 'storeQuestion']);
      Route::put('/question/update/{question}', [DiscussionQuestionController::class, 'updateQuestion']);
      Route::patch('/question/{question}/like', [DiscussionQuestionController::class, 'toggleLike']);
      Route::delete('/question/delete/{question}', [DiscussionQuestionController::class, 'deleteQuestion']);

      Route::get('/profile', [UserController::class, 'getProfile']);

      Route::post('/answer/store', [DiscussionAnswerController::class, 'storeAnswer']);
      Route::put('/answer/update/{answer}', [DiscussionAnswerController::class, 'updateAnswer']);
      Route::delete('/answer/delete/{answer}', [DiscussionAnswerController::class, 'deleteAnswer']);
});

/* 
* Semua Route dibawah ini nanti diubah ke web.php
*/

