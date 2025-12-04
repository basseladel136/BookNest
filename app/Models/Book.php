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
        'original_price',
        'description',
        'sale_price',
        'rating',
        'reviews_count',
        'category_id', // لو مربوط بالجدول category
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'original_price' => 'decimal:2',
        'sale_price' => 'decimal:2',
        'rating' => 'decimal:1',
        'reviews_count' => 'integer',
    ];

    // علاقة الكتاب بالـ Category
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // علاقة الكتاب بالـ Checkouts
    public function checkouts()
    {
        return $this->belongsToMany(Checkout::class)->withPivot('quantity')->withTimestamps();
    }

    // Accessor للصورة
    public function getCoverAttribute($value)
    {
        return $value ? asset('images/' . $value) : null;
    }

    // Scope للبحث
    public function scopeSearch($query, $term)
    {
        return $query->where('title', 'like', "%{$term}%")
            ->orWhere('author', 'like', "%{$term}%");
    }
}
