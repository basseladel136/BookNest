<?php

use App\Http\Controllers\Api\CheckoutApiController;
use App\Http\Controllers\Api\AuthApiController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;


// تسجيل الدخول


Route::post('/login', [AuthApiController::class, 'login']);
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// حفظ بيانات الطلب
Route::post('checkouts', [CheckoutApiController::class, 'process'])
    ->name('api.checkout.process');
Route::get('/test', function () {
    return response()->json(['ok' => true]);
});
Route::get('/test', function () {
    return response()->json(['ok' => true]);
});
