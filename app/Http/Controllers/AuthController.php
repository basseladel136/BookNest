<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;

class AuthController extends Controller
{
    // صفحة التسجيل
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

    // Quick Reset Password - عرض الفورم
    public function showQuickResetForm()
    {
        return view('auth.passwords.quick_reset');
    }

    // Quick Reset Password - تحديث الباسورد مباشرة
    public function quickResetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'password' => 'required|confirmed|min:8',
        ]);

        $user = User::where('email', $request->email)->first();
        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->route('login')->with('status', 'Password updated successfully!');
    }

    // إعادة تعيين كلمة المرور بالتوكن (اختياري)
    public function showResetForm($token)
    {
        return view('auth.passwords.reset', ['token' => $token]);
    }
}
