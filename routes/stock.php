<?php

use App\Http\Controllers\StockController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
   Route::get('/stock', [StockController::class, 'index']);

   Route::post('/stock', [StockController::class, 'store']);

   Route::get('/stock/{id}', [StockController::class, 'show']);

   Route::post('/stock/{id}/update', [StockController::class, 'update']);

   Route::delete('/stock/{id}/delete', [StockController::class, 'destroy']);
});