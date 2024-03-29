<?php

use App\Http\Controllers\Api\User\AuthController;
use App\Http\Controllers\Api\User\WishlistController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::controller(AuthController::class)->group(function () {
    Route::post('/login', 'login');
    Route::post('/register', 'register');
    Route::post('/otp-verify', 'verifyOtp');
    Route::post('/resend-otp', 'resendOtp');
});
Route::middleware('auth:user-api')->group(function () {
    Route::controller(AuthController::class)->group(function () {
        Route::post('/logout', 'logout');
        Route::get('/me', 'user');
    });
    Route::apiResources([
        'wishlist' => WishlistController::class,
    ]);
});
