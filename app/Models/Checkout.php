<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Checkout extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone_number',
        'address',
        'city',
        'zip_code',
        'payment_method',
        'user_id', // لو مستخدم مسجل
        'checkout_date',
    ];

    // تحويل checkout_date إلى كائن Carbon تلقائياً
    protected $casts = [
        'checkout_date' => 'datetime',
    ];

    /**
     * علاقة Checkout بالكتب
     */
    public function books()
    {
        return $this->belongsToMany(Book::class, 'book_checkout')
            ->withPivot('quantity')
            ->withTimestamps();
    }

    /**
     * علاقة Checkout بالمستخدم (اختياري)
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
