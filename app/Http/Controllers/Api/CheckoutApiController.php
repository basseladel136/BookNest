<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Checkout;

class CheckoutApiController extends Controller
{
    public function store(Request $request)
    {
        // Validation
        $validatedData = $request->validate([
            'first_name'     => 'required|string|max:255',
            'last_name'      => 'required|string|max:255',
            'email'          => 'required|email|max:255',
            'phone_number'   => 'required|string|max:20',
            'address'        => 'required|string|max:255',
            'city'           => 'required|string|max:100',
            'zip_code'       => 'required|string|max:20',
            'payment_method' => 'required|in:cod,paypal',
        ]);

        // optional: check for duplicate order
        $exists = Checkout::where('email', $validatedData['email'])
            ->where('phone_number', $validatedData['phone_number'])
            ->first();
        if ($exists) {
            return response()->json([
                'success' => false,
                'message' => 'طلب مماثل موجود بالفعل.'
            ], 409); // Conflict
        }

        // Save to DB
        $checkout = Checkout::create($validatedData);

        // Return Json response
        return response()->json([
            'success' => true,
            'message' => 'تم تسجيل الطلب بنجاح!',
            'order' => $checkout
        ], 201);
    }
}
