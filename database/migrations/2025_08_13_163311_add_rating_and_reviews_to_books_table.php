<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Schema::table('books', function (Blueprint $table) {
        //     // لإضافة حقل التقييم. يمكن أن يكون رقمًا عشريًا مثل 4.5
        //     // decimal(3, 2) تعني إجمالي 3 أرقام، منهم 2 بعد الفاصلة العشرية (مثل: 9.99)
        //     $table->decimal('rating', 3, 2)->default(0.00)->after('price');

        //     // لإضافة حقل عدد المراجعين. سيكون رقمًا صحيحًا
        //     $table->integer('reviews_count')->default(0)->after('rating');
        // });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('books', function (Blueprint $table) {
            $table->dropColumn(['rating', 'reviews_count']);
        });
    }
};
