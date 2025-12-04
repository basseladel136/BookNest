<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['id' => 1, 'name' => 'Fantasy'],
            ['id' => 2, 'name' => 'Horror' ],
            ['id' => 3, 'name' => 'Mystery' ],
            ['id' => 4, 'name' => 'Science Fiction' ],
            ['id' => 5, 'name' => 'Dystopian fiction' ],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
