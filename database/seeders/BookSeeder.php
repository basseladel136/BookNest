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
            'author' => 'George RR Martin',
            'price' => 50.00,
            'sale_price' => 44.99,
            'description' => "An anthology of 21 thrilling tales from acclaimed authors, featuring a brand-new A Game of Thrones story",
            'cover' => 'fantasy_1/rogues.jpg',
            'category_id' => 1,
            'rating' => 4.5,
            'reviews_count' => 100,
        ]);

        Book::create([
            'title' => 'Fevre Dream',
            'cover' => 'horror_2/fevre_dream.jpg',
            'description' => "A gripping historical vampire tale set on the Mississippi in 1857, as steamboat captain Abner Marsh partners with the mysterious Joshua York on a perilous and unforgettable journey.",
            'price' => 70.00,
            'author' => 'George RR Martin',
            'category_id' => 2,
            'sale_price' => 60.00,
            'rating' => 4.2,
            'reviews_count' => 85,

        ]);
        Book::create([
            'title' => 'Sherlock Holmes',
            'cover' => 'mystery_3/sherlock_holmes.jpg',
            'description' => "The complete works of Sherlock Holmes—four novels and five short story collections",
            'price' => 68.45,
            'author' => 'Sir Arhur Conan Doyle',
            'category_id' => 3,
            'sale_price' => 54.65,
            'rating' => 4.7,
            'reviews_count' => 120,

        ]);
        Book::create([
            'title' => 'يوتوبيا',
            'cover' => 'dystopian_fiction_5/utopia.jpg',
            'description' => "A chilling dystopian novel set in a divided Egypt of 2023, where the wealthy live in a guarded enclave called Utopia, and a dangerous trip beyond its walls threatens to shatter the fragile order.
",
            'price' => 25.23,
            'author' => 'احمد خالد توفيق',
            'category_id' => 5,
            'sale_price' => 18.50,
            'rating' => 4.0,
            'reviews_count' => 60,

        ]);
        Book::create([
            'title' => 'Starter villain',
            'cover' => 'science_fiction_4/starter_villain.jpg',
            'description' => "A comedic sci-fi adventure where an ordinary man inherits his uncle’s supervillain empire—complete with volcano lair, spy cats, and deadly enemies—and must learn to embrace the art of going bad.

",
            'price' => 48.25,
            'author' => 'John Scalzi ',
            'category_id' => 4,
            'sale_price' => 33.54,
            'rating' => 4.3,
            'reviews_count' => 90,

        ]);
        Book::create([
            'title' => 'The Rise of Dragon',
            'cover' => 'fantasy_1/the_rise_of_dragon.jpg',
            'description' => "An illustrated history of House Targaryen, featuring over 180 new artworks, chronicling their rise from Aegon’s conquest to the bloody Dance of the Dragons—perfect for fans of House of the Dragon and Fire & Blood.
",
            'price' => 100.00,
            'author' => 'George RR Martin',
            'category_id' => 1,
            'sale_price' => 89.99,
            'rating' => 4.0,
            'reviews_count' => 70,

        ]);
        Book::create([
            'title' => 'The Science of Interstellar',
            'cover' => 'science_fiction_4/the_science_of_intersteller.jpg',
            'description' => "A companion to the film Interstellar, exploring the real science behind the movie's depiction of black holes, wormholes, and time dilation, written by physicist Kip Thorne.",

            'price' => 75.00,
            'author' => 'Kip Thorne',
            'category_id' => 4,
            'sale_price' =>  69.99,
            'rating' => 4.4,
            'reviews_count' => 80,
        ]);
        Book::create([
            'title' => 'harry potter',
            'cover' => 'fantasy_1/harry_potter.jpg',
            'description' => 'Join Harry Potter on a thrilling fifth-year adventure at Hogwarts as he battles dark forces, uncovers secrets, and learns essential magic to protect himself. Packed with danger, friendship, and magical discoveries.',
            'price' => 89.99,
            'sale_price' => 70.00,
            'rating' => 3.8,
            'reviews_count' => 500,
            'category_id' => 1,
            'author' => 'J.K. Rowling',
        ]);
        Book::create([
            'title' => 'The lord of the rings',
            'cover' => 'fantasy_1/the_lord_of_the_rings.jpg',
            'description' => "The first part of Tolkien's epic Lord of the Rings, continuing from The Hobbit, featuring adventure, iconic characters, and a detailed map of Middle-earth.",
            'price' => 65.00,
            'sale_price' => 59.99,
            'rating' => 4.8,
            'reviews_count' => 400,
            'category_id' => 1,
            'author' => 'J.R.R. Tolkien',
        ]);
        Book::create([
            'title' => '1984',
            'cover' => 'dystopian_fiction_5/1984.jpg',
            'description' => "George Orwell's dystopian classic depicting a totalitarian future where Big Brother watches all, truth is manipulated, and freedom is suppressed.
",
            'price' => 49.99,
            'sale_price' => 42.99,
            'rating' => 4.0,
            'reviews_count' => 250,
            'category_id' => 5,
            'author' => 'George Orwell',
        ]);
        Book::create([
            'title' => 'الفيل الازرق',
            'cover' => 'horror_2/alfil_azraq.jpg',
            'description' => "A psychological thriller following Dr. Yehia as he confronts hidden mysteries and the supernatural, blending suspense with intense psychological investigations.

",
            'price' => 32.50,
            'sale_price' => 24.99,
            'rating' => 3.7,
            'reviews_count' => 100,
            'category_id' => 2,
            'author' => 'احمد مراد',
        ]);
        Book::create([
            'title' => 'تراب الماس',
            'cover' => 'mystery_3/trab_almas.jpg',
            'description' => "A gripping psychological thriller exploring dark human desires, obsession, and the hidden depths of the mind, keeping readers on the edge of their seats.

",
            'price' => 25.50,
            'sale_price' => 19.99,
            'rating' => 3.4,
            'reviews_count' => 100,
            'category_id' => 3,
            'author' => 'احمد مراد'
        ]);
    }
}
