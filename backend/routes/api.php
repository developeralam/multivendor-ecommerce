<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Admin\BrandController;
use App\Http\Controllers\Api\Admin\SliderController;
use App\Http\Controllers\Api\Admin\CategoryController;
use App\Http\Controllers\Api\Admin\DivisionController;
use App\Http\Controllers\Api\Admin\ProductController;
use App\Http\Controllers\Api\SellerController;
use App\Http\Controllers\Api\ShopController;

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

Route::prefix('v1')->group(function () {
    Route::get('category', [CategoryController::class, 'index']);
    Route::get('slider', [SliderController::class, 'index']);
    Route::get('product', [ProductController::class, 'index']);
    Route::get('brand', [BrandController::class, 'index']);
    Route::get('division', [DivisionController::class, 'index']);
    Route::get('seller', [SellerController::class, 'index']);
    Route::get('seller/products/{slug}', [SellerController::class, 'sellerProducts']);
    Route::get('shops', [ShopController::class, 'index']);
    Route::get('/sidebar', [ShopController::class, 'sidebar']);
});
