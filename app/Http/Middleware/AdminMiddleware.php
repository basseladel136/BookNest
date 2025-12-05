<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::guard('sanctum')->user();

        if (!$user || $user->role !== 'admin') {
            return response()->json([
                'message' => 'Admins only'
            ], 403);
        }

        return $next($request);
    }
}
