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
    ];

    // علاقة checkout بالكتب
    public function books()
    {
        return $this->belongsToMany(Book::class, 'book_checkout')->withPivot('quantity')->withTimestamps();
    }



    // علاقة checkout بالمستخدم (اختياري)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
