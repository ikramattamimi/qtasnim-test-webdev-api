<?php

use App\Http\Controllers\api\ProductController;
use App\Http\Controllers\api\ProductTypeController;
use App\Http\Controllers\api\TransactionController;
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

Route::apiResource('product', ProductController::class);
Route::apiResource('product-type', ProductTypeController::class);
Route::apiResource('transaction', TransactionController::class);

Route::post('/transaction/search', [TransactionController::class, 'search']);
Route::post('/product-type/compare', [ProductTypeController::class, 'compare']);
