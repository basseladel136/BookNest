<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\BookController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\UserController;
use App\Models\Book;
use App\Models\Category;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Home
Route::get('/', [BookController::class, 'index'])->name('home');

// Books CRUD (Auth)
Route::middleware('auth')->group(function () {
    Route::resource('books', BookController::class);
});

// Auth
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/auth/login', [AuthController::class, 'login'])->name('login.post');

Route::post('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect()->route('login');
})->name('logout');

// Password reset
Route::get('password/quick-reset', [AuthController::class, 'showQuickResetForm'])->name('password.request');
Route::post('password/quick-reset', [AuthController::class, 'quickResetPassword'])->name('password.update');
Route::get('password/reset/{token}', [AuthController::class, 'showResetForm'])->name('password.reset');

// Cart & Checkout
Route::middleware('auth')->group(function () {
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add/{book}', [CartController::class, 'add'])->name('cart.add');
    Route::patch('/cart/update', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');

    Route::get('/cart/checkout', [CartController::class, 'checkoutView'])->name('cart.checkout');
    Route::post('/checkout', [CartController::class, 'processCheckout'])->name('checkout.process');

    Route::get('/checkout/success', function () {
        return view('checkout.success');
    })->name('checkout.success');

    Route::get('/cart/my_order', [CartController::class, 'myOrders'])
        ->name('cart.my_order');
});

// Search
Route::get('/search', [BookController::class, 'search'])->name('books.search');

// User Profile
Route::middleware('auth')->group(function () {
    Route::get('users/profile', [UserController::class, 'profile'])->name('users.profile');
    Route::get('users/profile/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::post('users/profile/update', [UserController::class, 'update'])->name('users.profile.update');
});

// ✅ Admin Books Page (الصحيحة)
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/books', function () {
        $books = Book::with('category')->latest()->get();
        $categories = Category::all();

        return view('admin.books', compact('books', 'categories'));
    })->name('admin.books');
});
