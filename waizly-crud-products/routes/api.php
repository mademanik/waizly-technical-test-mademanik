<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ProductController;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('register', [AuthController::class, 'register'])->name('register');
Route::post('login', [AuthController::class, 'login'])->name('login');
Route::group(['middleware' => ['auth:api']], function () {
    Route::get('user', [AuthController::class, 'userProfile'])->name('userProfile');
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');

    Route::post('/products', [ProductController::class, 'createProduct']);
    Route::put('/product/{id}', [ProductController::class, 'updateProductById']);
    Route::delete('/product/{id}', [ProductController::class, 'deleteProductById']);
    Route::get('/products', [ProductController::class, 'findAllProducts']);
    Route::get('/products/{id}', [ProductController::class, 'findProductById']);
});
