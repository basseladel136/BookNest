<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Checkout;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // جلب كل الأوردرات الخاصة بالمستخدم من جدول checkouts
        $checkouts = Checkout::where('user_id', $user->id)
            ->orderBy('checkout_date', 'desc')
            ->get();

        return view('checkouts.index', compact('checkouts'));
    }
}
