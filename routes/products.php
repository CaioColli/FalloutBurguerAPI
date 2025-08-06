<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ProductsController;

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/products', [ProductsController::class, 'store']);
    
    Route::get('/products/{id}', [ProductsController::class, 'show']);

    Route::post('/products/{id}/update', [ProductsController::class, 'update']);
});