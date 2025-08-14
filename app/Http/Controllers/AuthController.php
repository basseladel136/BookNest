<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;

class AuthController extends Controller
{
    public function showRegisterForm()
    {
        return view("auth.register");
    }

    // تسجيل مستخدم جديد
    public function register(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name'  => 'required|string|max:255',
            'email'      => 'required|string|email|max:255|unique:users',
            'password'   => 'required|string|min:6|confirmed',
        ]);

        $user = User::create([
            'first_name' => $request->first_name,
            'last_name'  => $request->last_name,
            'email'      => $request->email,
            'password'   => Hash::make($request->password),
        ]);

        Auth::login($user);

        return redirect()->route('books.index')
            ->with('success', 'Welcome, ' . e($user->first_name . '!'));
    }

    // صفحة تسجيل الدخول
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // تنفيذ تسجيل الدخول
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended(route('books.index'));
        }

        return back()->withErrors([
            'email' => 'Invalid credentials.',
        ]);
    }

    // صفحة نسيت كلمة المرور
    public function showForgotPasswordForm()
    {
        return view('auth.forgot-password');
    }

    // إرسال رابط إعادة تعيين الباسورد
    public function sendResetLink(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $status = Password::sendResetLink($request->only('email'));

        return $status === Password::RESET_LINK_SENT
            ? back()->with(['status' => __($status)])
            : back()->withErrors(['email' => __($status)]);
    }
   
}
