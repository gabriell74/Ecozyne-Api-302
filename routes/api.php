<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\GalleryController;


Route::post('/daftar', [AuthController::class, 'daftar']);
Route::post('/login', [AuthController::class, 'login']);

Route::get('/admin/gallery', [GalleryController::class, 'index']);

Route::middleware('auth:sanctum')->group(function () {
      Route::post('/logout', [AuthController::class, 'logout']);
      // Add other protected API routes here
});

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');
