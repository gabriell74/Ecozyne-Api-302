<?php

use Illuminate\Http\Request;
use App\Models\TrashTransaction;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\OtpController;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\ComicController;
use App\Http\Controllers\API\RegionController;
use App\Http\Controllers\API\ArticleController;
use App\Http\Controllers\API\GalleryController;
use App\Http\Controllers\API\ProductController;
use App\Http\Controllers\API\ActivityController;
use App\Http\Controllers\API\WasteBankController;
use App\Http\Controllers\api\PointExchangeController;
use App\Http\Controllers\API\OrderCommunityController;
use App\Http\Controllers\API\OrderWasteBankController;
use App\Http\Controllers\API\CommunityHistoryController;
use App\Http\Controllers\API\DiscussionAnswerController;
use App\Http\Controllers\API\ProductWasteBankController;
use App\Http\Controllers\API\TrashTransactionController;
use App\Http\Controllers\API\EcoEnzymeTrackingController;
use App\Http\Controllers\API\DiscussionQuestionController;
use App\Http\Controllers\API\WasteBankSubmissionController;

Route::post('/register', [UserController::class, 'register']);
Route::get('/regions', [RegionController::class, 'index']);

Route::post('/login', [AuthController::class, 'login'])->middleware('throttle:login');

Route::get('/admin/gallery', [GalleryController::class, 'index']);

Route::get('/articles', [ArticleController::class, 'index']);
Route::get('/articles/latest', [ArticleController::class, 'latestArticles']);

Route::get('/questions', [DiscussionQuestionController::class, 'getAllQuestion']);

Route::get('/answers/{questionId}', [DiscussionAnswerController::class, 'getAllAnswer']);

Route::get('/activities', [ActivityController::class, 'getAllActivity']);
Route::get('/activities/latest', [ActivityController::class, 'getLatestActivity']);
Route::get('/activities/completed', [ActivityController::class, 'getCompletedActivity']);

Route::get('/comics', [ComicController::class, 'getAllComics']);
Route::get('/comics/{id}', [ComicController::class, 'getComicById']);

Route::get('/rewards', [PointExchangeController::class, 'getAllRewards']);
Route::get('/rewards/{rewardId}', [PointExchangeController::class, 'getRewardStockById']);

Route::get('/marketplace/products', [ProductController::class, 'getAllProduct']);
Route::get('/marketplace/products/{id}', [ProductController::class, 'getProductDetail']);

Route::get('/waste-banks', [WasteBankController::class, 'getAllWasteBank']);
Route::get('/waste-banks/{wasteBank}', [WasteBankController::class, 'wasteBankDetail']);

Route::post('/send-otp', [OtpController::class, 'sendOtp']);
Route::post('/verify-otp', [OtpController::class, 'verifyOtp']);

Route::middleware('auth:sanctum')->group(function () {
      Route::post('/logout', [AuthController::class, 'logout']);
      
      Route::post('/validate-password', [UserController::class, 'validatePassword']);

      Route::put('/update-profile', [UserController::class, 'updateProfile']);
      
      Route::post('/question/store', [DiscussionQuestionController::class, 'storeQuestion']);
      Route::put('/question/update/{question}', [DiscussionQuestionController::class, 'updateQuestion']);
      Route::patch('/question/{question}/like', [DiscussionQuestionController::class, 'toggleLike']);
      Route::delete('/question/delete/{question}', [DiscussionQuestionController::class, 'deleteQuestion']);

      Route::get('/profile', [UserController::class, 'getProfile']);
      
      Route::post('/answer/store/{questionId}', [DiscussionAnswerController::class, 'storeAnswer']);
      Route::put('/answer/update/{answer}', [DiscussionAnswerController::class, 'updateAnswer']);
      Route::delete('/answer/delete/{answer}', [DiscussionAnswerController::class, 'deleteAnswer']);
      
      Route::post('/activities/{activity}/register', [ActivityController::class, 'activityRegister']);
      Route::get('/activities/registration/history', [ActivityController::class, 'getCommunityActivityRegistrations']);
      Route::get('/activities/{id}/is-registered', [ActivityController::class, 'checkRegistrationStatus']);
      
      Route::post('/reward/exchange/{reward}', [PointExchangeController::class, 'exchangeReward']);
      
      Route::get('/reward/exchange/history', [CommunityHistoryController::class, 'rewardExchangeHistory']);
      Route::get('/point/income/history', [CommunityHistoryController::class, 'pointIncomeHistory']);
      Route::get('/product/order/history', [CommunityHistoryController::class, 'productOrderHistory']);
      
      Route::get('/eco-enzyme-tracking/get-all-batches', [EcoEnzymeTrackingController::class, 'getAllBatches']);
      Route::post('/eco-enzyme-tracking/store-batch', [EcoEnzymeTrackingController::class, 'storeBatch']);
      
      Route::post('/waste-bank-submission/store', [WasteBankSubmissionController::class, 'storeWasteBankSubmission']);
      Route::get('/waste-bank-submission/history', [WasteBankSubmissionController::class, 'getSubmissionHistory']);
      Route::get('/waste-bank-submissions/check-status', [WasteBankSubmissionController::class, 'checkSubmissionsStatus']);

      Route::prefix('/orders/community')->group(function () {
        Route::post('/{product}/place', [OrderCommunityController::class, 'placeOrder']);
        Route::put('/{orderId}/cancel', [OrderCommunityController::class, 'cancelOrder']);
      });
      
      Route::prefix('/waste-bank/orders')->group(function () {
        Route::get('/', [OrderWasteBankController::class, 'getWasteBankOrders']);
        Route::put('/{order}/accept', [OrderWasteBankController::class, 'acceptOrder']);
        Route::put('/{order}/reject', [OrderWasteBankController::class, 'rejectOrder']);
        Route::put('/{order}/complete', [OrderWasteBankController::class, 'completeOrder']);
      });

      Route::prefix('/waste-bank/products')->group(function () {
        Route::get('/', [ProductWasteBankController::class, 'getWasteBankProducts']);
        Route::get('/{id}', [ProductWasteBankController::class, 'getWasteBankProductDetail']);
        Route::post('/create', [ProductWasteBankController::class, 'createWasteBankProduct']);
        Route::put('/{id}/update', [ProductWasteBankController::class, 'updateWasteBankProduct']);
        Route::delete('/{id}/delete', [ProductWasteBankController::class, 'deleteWasteBankProduct']);
      });

      Route::post('/trash-submissions/{wasteBankId}', [TrashTransactionController::class, 'trashTransactionByUser']);
      Route::get('/trash-submissions/waste-bank/{wasteBankId}', [TrashTransactionController::class, 'trashTransactionByWasteBank']);
      Route::put('/trash-submissions/{id}/approve', [TrashTransactionController::class, 'approveTransaction']);
      Route::put('/trash-submissions/{id}/store', [TrashTransactionController::class, 'storeTrash']);
      Route::put('/trash-submissions/{id}/reject', [TrashTransactionController::class, 'rejectTransaction']);
      Route::get('/trash-submissions/user/history', [TrashTransactionController::class, 'historyByUser']);
    });
    
/* 
* Semua Route dibawah ini nanti diubah ke web.php
*/

