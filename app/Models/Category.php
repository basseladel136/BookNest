<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    // الحقول اللي مسموح بالتعبئة الجماعية (Mass Assignment)
    protected $fillable = [
        'name',
    ];

    /**
     * العلاقة بين Category و Book
     * كل Category ممكن يكون عندها كتب كتيرة
     */
    public function books()
    {
        return $this->hasMany(Book::class);
    }
}
