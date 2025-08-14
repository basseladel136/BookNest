<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Book;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Book::create([
            'title' => 'Rogues',
            'cover' => 'images/rogues.jpg',
            'description' => "An anthology of 21 thrilling tales from acclaimed authors, featuring a brand-new A Game of Thrones story",
            'id' => 1,
            'price' => 50.00,
            'author' => 'George RR Martin',
            'category' => 'Fantasy',
            'sale_price' => 44.99,
        ]);

        Book::create([
            'title' => 'Fevre Dream',
            'cover' => 'images/fevre dream.jpg',
            'description' => "A gripping historical vampire tale set on the Mississippi in 1857, as steamboat captain Abner Marsh partners with the mysterious Joshua York on a perilous and unforgettable journey.",
            'id' => 2,
            'price' => 70.00,
            'author' => 'George RR Martin',
            'category' => 'Horror',
            'sale_price' => 60.00,

        ]);
        Book::create([
            'title' => 'Sherlock Holmes',
            'cover' => 'images/sherlock holmes.webp',
            'description' => "The complete works of Sherlock Holmes—four novels and five short story collections",
            'id' => 3,
            'price' => 68.45,
            'author' => 'Sir Arhur Conan Doyle',
            'category' => 'Mystery',
            'sale_price' => 54.65,

        ]);
        Book::create([
            'title' => 'يوتوبيا',
            'cover' => 'images/يوتوبيا.jpg',
            'description' => "A chilling dystopian novel set in a divided Egypt of 2023, where the wealthy live in a guarded enclave called Utopia, and a dangerous trip beyond its walls threatens to shatter the fragile order.
",
            'id' => 4,
            'price' => 25.23,
            'author' => 'احمد خالد توفيق',
            'category' => 'Dystopian Fiction',
            'sale_price' => 18.50,

        ]);
        Book::create([
            'title' => 'Starter villain',
            'cover' => 'images/starter villain.jpg',
            'description' => "A comedic sci-fi adventure where an ordinary man inherits his uncle’s supervillain empire—complete with volcano lair, spy cats, and deadly enemies—and must learn to embrace the art of going bad.

",
            'id' => 5,
            'price' => 48.25,
            'author' => 'John Scalzi ',
            'category' => 'Science Fiction',
            'sale_price' => 33.54,

        ]);
        Book::create([
            'title' => 'The Rise of Dragon',
            'cover' => 'images/the rise of dragon.jpg',
            'description' => "An illustrated history of House Targaryen, featuring over 180 new artworks, chronicling their rise from Aegon’s conquest to the bloody Dance of the Dragons—perfect for fans of House of the Dragon and Fire & Blood.
",
            'id' => 6,
            'price' => 100.00,
            'author' => 'George RR Martin',
            'category' => 'Fantasy',
            'sale_price' => 89.99,

        ]);
    }
}
