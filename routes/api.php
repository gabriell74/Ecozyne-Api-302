<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\GalleryController;
use App\Http\Controllers\API\RegionController;
use App\Http\Controllers\API\UserController;

Route::post('/register', [UserController::class, 'register']);
Route::get('/regions', [RegionController::class, 'index']);

Route::post('/login', [AuthController::class, 'login']);

Route::get('/admin/gallery', [GalleryController::class, 'index']);

// Route::middleware('auth:sanctum')->group(function () {
      Route::post('/logout', [AuthController::class, 'logout']);

      Route::post('/change-expired-password', [UserController::class, 'changeExpiredPassword']);

      Route::post('/validate-password', [UserController::class, 'validatePassword']);
      // Add other protected API routes here
// });

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');
