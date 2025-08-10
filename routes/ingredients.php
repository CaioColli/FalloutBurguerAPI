<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\IngredientsController;

Route::middleware('auth:sanctum')->group(function () {
    Route::post('products/{product_id}/ingredients', [IngredientsController::class, 'store']);

    Route::get('products/{product_id}/ingredients', [IngredientsController::class, 'show']);

    Route::post('products/{product_id}/ingredients/{ingredient_id}/update', [IngredientsController::class, 'update']);

    Route::delete('products/{product_id}/ingredients/{ingredient_id}/delete', [IngredientsController::class, 'destroy']);
});