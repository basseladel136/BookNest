<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Checkout;
use App\Models\Book;
use App\Models\User;

class CheckoutsSeeder extends Seeder
{
    public function run(): void
    {/*
        // مثال على Checkout أول
        $checkout1 = Checkout::create([
            'user_id' => 1,
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'john@example.com',
            'phone_number' => '0123456789',
            'address' => '123 Street',
            'city' => 'Cairo',
            'zip_code' => '12345',
            'payment_method' => 'cod',
            'checkout_date' => now(),
        ]);

        // ربط الكتب بالـ pivot table
        $checkout1->books()->attach([
            1 => ['quantity' => 1, ],
            2 => ['quantity' => 2, ],
        ]);

        // مثال على Checkout تاني
        $checkout2 = Checkout::create([
            'user_id' => 2,
            'first_name' => 'Alice',
            'last_name' => 'Smith',
            'email' => 'alice@example.com',
            'phone_number' => '0987654321',
            'address' => '456 Avenue',
            'city' => 'Giza',
            'zip_code' => '54321',
            'payment_method' => 'visa_card',
        ]);

        $checkout2->books()->attach([
            3 => ['quantity' => 1,],
        ]);
     */}
}
