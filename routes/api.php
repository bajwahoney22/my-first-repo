<?php

use App\Http\Controllers\Api\AuthApiController;
use App\Http\Controllers\Api\BrandApiController;
use App\Http\Controllers\Api\CategoryApiController;
use App\Http\Controllers\Api\ProductApiController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:api')->group(function(){

    
    Route::get('/products', [ProductApiController::class, 'index']);
    Route::post('/products', [ProductApiController::class, 'store']);
    Route::get('/products/{product}', [ProductApiController::class, 'show']);
    // Route::delete('/products/{product}/destroy', [ProductApiController::class, 'destroy']);
    Route::delete('/products/{product}', [ProductApiController::class, 'delete']);
    Route::post('/brand', [BrandApiController::class, 'store']);
    Route::get('/brand', [BrandApiController::class, 'index']);
    Route::delete('/brand/{brand}', [BrandApiController::class, 'delete']);
    Route::get('/category', [CategoryApiController::class, 'index']);
    Route::post('/category', [CategoryApiController::class, 'store']);
    Route::delete('/category/{category}', [CategoryApiController::class, 'delete']);
    // Route::delete('/categories/{category}/delete', [CategoryApiController::class, 'delete']);
});

Route::post('/login', [AuthApiController::class, 'login']);