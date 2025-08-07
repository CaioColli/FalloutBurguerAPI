<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\IngredientsController;

Route::middleware('auth:sanctum')->group(function () {
    
    Route::delete('/ingredients/{id}/delete', [IngredientsController::class, 'destroy']);

    Route::post('/ingredients/{id}/update', [IngredientsController::class, 'update']);
});