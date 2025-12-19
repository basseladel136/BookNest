<?php

namespace App\Http\Controllers;

use App\Models\User;
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

    // عرض فورم التعديل
    public function edit()
    {
        $user = Auth::user();
        return view('users.edit_profile', compact('user'));
    }

    // حفظ التعديلات
    public function update(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name'  => 'required|string|max:255',
            'email'      => 'required|email|max:255|unique:users,email,' . $user->id,
            'password'   => 'nullable|string|min:6|confirmed',
            'phone'      => 'nullable|string|max:20',
            'about'      => 'nullable|string',
            'favorite_genres' => 'nullable|array',
            'favorite_genres.*' => 'string|max:50',
        ]);

        // تحديث البيانات الأساسية
        $user->first_name = $validated['first_name'];
        $user->last_name  = $validated['last_name'];
        $user->email      = $validated['email'];
        $user->update([
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'about' => $validated['about'],
            'favorite_genres' => $validated['favorite_genres'] ?? [],
        ]);

        // تحديث الباسورد لو اتكتب
        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }

        $user->save();

        return redirect()
            ->route('users.profile')
            ->with('success', 'Profile updated successfully!');
    }
}
