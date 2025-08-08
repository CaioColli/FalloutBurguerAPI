<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\DrinksController;
use App\Http\Controllers\ProductsController;

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/products', [ProductsController::class, 'index']); 
    Route::get('/products/drinks', [DrinksController::class, 'index']); 

    Route::post('/products', [ProductsController::class, 'store']);
    Route::post('/products/drinks', [DrinksController::class, 'store']);
    
    Route::get('/products/{id}', [ProductsController::class, 'show']);
    Route::get('/products/drinks/{id}', [DrinksController::class, 'show']);

    Route::post('/products/{id}/update', [ProductsController::class, 'update']);
    Route::post('/products/drink/{id}/update', [DrinksController::class, 'update']);

    Route::delete('/products/{id}/delete', [ProductsController::class, 'destroy']);
    Route::delete('/products/drink/{id}/delete', [DrinksController::class, 'destroy']);
});