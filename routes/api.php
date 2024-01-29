<?php

use App\Http\Controllers\BrandController;
use App\Http\Controllers\ClientController;
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

Route::get('/client', [ClientController::class, 'index']);
Route::post('/client', [ClientController::class, 'store']);
Route::get('/client/{id}', [ClientController::class, 'show']);
Route::put('/client/{id}', [ClientController::class, 'update']);
Route::delete('/client/{id}', [ClientController::class, 'destroy']);
Route::get('/client/restore/{id}', [ClientController::class, 'restore']);
