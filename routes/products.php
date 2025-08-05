<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ProductsController;

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/products', [ProductsController::class, 'store']);
});