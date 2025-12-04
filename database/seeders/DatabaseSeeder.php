<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // أولاً المستخدمين
        $this->call(UserSeeder::class);

        // ثانياً التصنيفات
        $this->call(CategorySeeder::class);

        // ثالثاً الكتب
        $this->call(BookSeeder::class);

        // رابعاً checkouts
        $this->call(CheckoutsSeeder::class);
    }
}
