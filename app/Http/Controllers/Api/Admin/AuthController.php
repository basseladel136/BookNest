<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;



class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }


        /** @var \App\Models\User|null $user */
        $user = Auth::user();
        if (! $user) {
            return response()->json(['message' => 'Unauthenticated'], 401);
        }
        // @var \App\Models\User $user
        if ($user->role !== 'admin') {
            return response()->json(['message' => 'Not an admin'], 403);
        }
        $token = $user->createToken('admin-token')->plainTextToken;
        return response()->json([
            'message' => 'Admin authenticated',
            'token' => $token,
            'user' => $user
        ]);
    }
}
