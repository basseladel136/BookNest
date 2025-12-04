<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Admin\BookController;

    Route::middleware(['auth:sanctum', 'admin'])->prefix('admin')->group(function () {
    Route::apiResource('books', BookController::class);
});

