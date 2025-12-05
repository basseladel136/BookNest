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

        // retrieve the authenticated user model instance

        $user = Auth::guard('sanctum')->user(); // أو Auth::user() لو API جديد
        if (!$user) {
            return response()->json(['status' => 'error', 'message' => 'User not authenticated'], 401);
        }
        $user = Auth::user();
        /** @var \App\Models\User $user */
        if (!$user) {
            return response()->json(['message' => 'User not authenticated'], 401);
        }

        if ($user->role !== 'admin') {
            return response()->json(['message' => 'Not an admin'], 403);
        }

        $token = $user->createToken('admin-token')->plainTextToken;

        return response()->json([
            'message' => 'Admin authenticated',
            'token' => $token
        ]);
    }
}
