<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // عرض بيانات البروفايل
    public function profile()
    {
        $user = Auth::user();
        return view('users.profile', compact('user'));
    }

    // عرض الفورم للتعديل
    public function edit()
    {
        $user = Auth::user();
        return view('users.edit_profile', compact('user'));
    }

    // حفظ التعديلات
    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->email = $request->email;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }
        /** @var \App\Models\User $user */
        $user->save();

        return redirect()->route('users.profile')->with('success', 'Profile updated successfully!');
    }
}
