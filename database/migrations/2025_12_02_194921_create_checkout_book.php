<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('book_checkout', function (Blueprint $table) {
            $table->id();
            $table->foreignId('book_id')->constrained()->onDelete('cascade');
            $table->foreignId('checkout_id')->constrained()->onDelete('cascade');
            $table->integer('quantity')->default(1); // لو محتاج تحفظ كمية
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('book_checkout');
    }
};
