<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\BookController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController; // إذا عندك كنترولر خاص للشيك أوت

/*
| الصفحة الرئيسية
*/

Route::get('/', [BookController::class, 'index'])->name('home');

/*
| إدارة الكتب (محمية بتسجيل الدخول)
*/
Route::middleware('auth')->group(function () {
    Route::resource('books', BookController::class);
    Route::get('/books', [BookController::class, 'index'])->name('books.index');
});

/*
| التسجيل
*/
Route::get('/register', [AuthController::class, 'showRegisterForm'])

    ->name('register');

Route::post('/register', [AuthController::class, 'register'])

    ->name('register.post');

/*
| تسجيل الدخول
*/
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::post('/auth/login', [AuthController::class, 'login'])

    ->name('login.post');
Route::get('/forgot-password', [AuthController::class, 'showForgotPasswordForm'])->name('password.request');
Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])->name('password.email');

/*
| تسجيل الخروج
*/
Route::post('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect()->route('login');
})->name('logout');

/*
| مسارات السلة
*/
// لا تكرّر المسارات!
// مرّة واحدة فقط لكل أمر:
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add/{book}', [CartController::class, 'add'])->name('cart.add');
Route::patch('/cart/update', [CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');
Route::get('/cart/checkout', [CartController::class, 'checkoutView'])->name('cart.checkout');

/*
| مسارات الشيك أوت
*/

// عرض صفحة الفورم (تفتح resources/views/cart/checkout.blade.php)
Route::get('/checkout', function () {
    return view('cart.checkout');
})->name('checkout.form');

// معالجة (حفظ) بيانات الطلب والدفع
Route::post('/checkout', [CartController::class, 'process'])->name('checkout.process');

// صفحة نجاح الطلب بعد الحفظ
Route::get('/checkout/success', function () {
    return view('checkout.success');
})->name('checkout.success');
