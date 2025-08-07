<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\IngredientsController;

Route::middleware('auth:sanctum')->group(function () {
    
    Route::post('/ingredients', [IngredientsController::class, 'store']);

    Route::delete('/ingredients/{id}/delete', [IngredientsController::class, 'destroy']);
});