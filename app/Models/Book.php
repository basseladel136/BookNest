<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'author',
        'cover',
        'price',
        'original_price', // تأكد من إضافة كل الحقول
        'description',
        'category',
        'sale_price',

        // أضف السطرين التاليين
        'rating',
        'reviews_count',
    ];
}
