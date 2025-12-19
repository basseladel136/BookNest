<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Admin\BookController;
use App\Http\Controllers\Api\Admin\AuthController;

// Login Admin
Route::post('admin/login', [AuthController::class, 'login']);


// Admin CRUD routes
Route::middleware(['auth:sanctum', 'admin'])->prefix('admin')->group(function () {
    Route::apiResource('books', BookController::class);
});
