<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\BookController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;

// الصفحة الرئيسية
Route::get('/', [BookController::class, 'index'])->name('home');

// إدارة الكتب (محمية بتسجيل الدخول)
Route::middleware('auth')->group(function () {
    Route::resource('books', BookController::class);
    Route::get('/books', [BookController::class, 'index'])->name('books.index');
});

// التسجيل
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');

// تسجيل الدخول
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/auth/login', [AuthController::class, 'login'])->name('login.post');

// Quick Password Reset (عرض الفورم ومعالجته)
Route::get('password/quick-reset', [AuthController::class, 'showQuickResetForm'])->name('password.request');
Route::post('password/quick-reset', [AuthController::class, 'quickResetPassword'])->name('password.update');

// إعادة تعيين كلمة المرور باستخدام التوكن (اختياري)
Route::get('password/reset/{token}', [AuthController::class, 'showResetForm'])->name('password.reset');

// تسجيل الخروج
Route::post('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect()->route('login');
})->name('logout');

// مسارات السلة والشيك أوت (محمية بتسجيل الدخول)
Route::middleware('auth')->group(function () {
    // السلة
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add/{book}', [CartController::class, 'add'])->name('cart.add');
    Route::patch('/cart/update', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');
    Route::get('/cart/checkout', [CartController::class, 'checkoutView'])->name('cart.checkout');

    // الشيك أوت
    Route::get('/checkout', function () {
        return view('cart.checkout');
    })->name('checkout.form');

    Route::post('/checkout', [CartController::class, 'process'])->name('checkout.process');

    Route::get('/checkout/success', function () {
        return view('checkout.success');
    })->name('checkout.success');
});
