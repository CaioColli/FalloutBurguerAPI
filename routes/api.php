<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::middleware('check.api.key')->group(function () {
    Route::prefix('auth')->group(base_path('routes/auth.php'));
});

