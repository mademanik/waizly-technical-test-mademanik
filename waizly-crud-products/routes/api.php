<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\SubAdminController;
use App\Http\Controllers\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware' => ['jwt.auth']], function () {
    Route::group(['prefix' => 'admin', 'middleware' => ['jwt.role:admin']], function () {
        Route::post('/logout', [AdminController::class, 'logout']);
        Route::get('/user-profile', [AdminController::class, 'userProfile']);
        Route::get('/products', [ProductController::class, 'findAllProducts']);
        Route::post('/products', [ProductController::class, 'createProduct']);
        Route::get('/products/{id}', [ProductController::class, 'findProductById']);
        Route::put('/product/{id}', [ProductController::class, 'updateProductById']);
        Route::delete('/product/{id}', [ProductController::class, 'deleteProductById']);
    });

    Route::group(['prefix' => 'subadmin', 'middleware' => ['jwt.role:subadmin']], function () {
        Route::post('/logout', [SubAdminController::class, 'logout']);
        Route::get('/user-profile', [SubAdminController::class, 'userProfile']);
    });
});

Route::group(['prefix' => 'admin'], function () {
    Route::post('/login', [AdminController::class, 'login']);
    Route::post('/register', [AdminController::class, 'register']);
});

Route::group(['prefix' => 'subadmin'], function () {
    Route::post('/login', [SubAdminController::class, 'login']);
    Route::post('/register', [SubAdminController::class, 'register']);
});
