<?php

use App\Http\Controllers\BrandController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ClotheController;
use App\Http\Controllers\DetailcartController;
use App\Http\Controllers\FootwearController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\StateController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/brands', [BrandController::class, 'index']);
Route::post('/brand', [BrandController::class, 'store']);
Route::get('/brand/{id}', [BrandController::class, 'show']);
Route::put('/brand/{id}', [BrandController::class, 'update']);
Route::delete('/brand/{id}', [BrandController::class, 'destroy']);
Route::get('/brand/restore/{id}', [BrandController::class, 'restore']);

Route::get('/products', [ProductController::class, 'index']);
Route::post('/product', [ProductController::class, 'store']);
Route::get('/product/{id}', [ProductController::class, 'show']);
Route::put('/product/{id}', [ProductController::class, 'update']);
Route::delete('/product/{id}', [ProductController::class, 'destroy']);
Route::get('/product/restore/{id}', [ProductController::class, 'restore']);

Route::get('/client', [ClientController::class, 'index']);
Route::post('/client', [ClientController::class, 'store']);
Route::get('/client/{id}', [ClientController::class, 'show']);
Route::put('/client/{id}', [ClientController::class, 'update']);
Route::delete('/client/{id}', [ClientController::class, 'destroy']);
Route::get('/client/restore/{id}', [ClientController::class, 'restore']);

Route::get('/states', [StateController::class, 'index']);
Route::post('/state', [StateController::class, 'store']);
Route::get('/state/{id}', [StateController::class, 'show']);
Route::put('/state/{id}', [StateController::class, 'update']);
Route::delete('/state/{id}', [StateController::class, 'destroy']);
Route::get('/state/restore/{id}', [StateController::class, 'restore']);

Route::get('/carts', [CartController::class, 'index']);
Route::post('/cart', [CartController::class, 'store']);
Route::get('/cart/{id}', [CartController::class, 'show']);
Route::put('/cart/{id}', [CartController::class, 'update']);
Route::delete('/cart/{id}', [CartController::class, 'destroy']);
Route::get('/cart/restore/{id}', [CartController::class, 'restore']);

Route::get('/clothes', [ClotheController::class, 'index']);
Route::post('/clothe', [ClotheController::class, 'store']);
Route::get('/clothe/{id}', [ClotheController::class, 'show']);
Route::put('/clothe/{id}', [ClotheController::class, 'update']);
Route::delete('/clothe/{id}', [ClotheController::class, 'destroy']);
Route::get('/clothe/restore/{id}', [ClotheController::class, 'restore']);

Route::get('/Footwears', [FootwearController::class, 'index']);
Route::post('/Footwear', [FootwearController::class, 'store']);
Route::get('/Footwear/{id}', [FootwearController::class, 'show']);
Route::put('/Footwear/{id}', [FootwearController::class, 'update']);
Route::delete('/Footwear/{id}', [FootwearController::class, 'destroy']);
Route::get('/Footwear/restore/{id}', [FootwearController::class, 'restore']);

Route::get('/detailcarts', [DetailcartController::class, 'index']);
Route::post('/detailcart', [DetailcartController::class, 'store']);
Route::get('/detailcart/{id}', [DetailcartController::class, 'show']);
Route::put('/detailcart/{id}', [DetailcartController::class, 'update']);
Route::delete('/detailcart/{id}', [DetailcartController::class, 'destroy']);
Route::get('/detailcart/restore/{id}', [DetailcartController::class, 'restore']);

