<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Book;

class BookSeeder extends Seeder
{
    public function run(): void
    {
        $books = [
            ['judul_buku' => 'Pulang', 'genre_id' => 1, 'author_id' => 1, 'tahun_terbit' => 2015, 'harga' => 85000],
            ['judul_buku' => 'Bumi Manusia', 'genre_id' => 5, 'author_id' => 2, 'tahun_terbit' => 1980, 'harga' => 95000],
            ['judul_buku' => 'Supernova: Ksatria, Puteri, dan Bintang Jatuh', 'genre_id' => 1, 'author_id' => 3, 'tahun_terbit' => 2001, 'harga' => 88000],
            ['judul_buku' => 'Laskar Pelangi', 'genre_id' => 1, 'author_id' => 4, 'tahun_terbit' => 2005, 'harga' => 75000],
            ['judul_buku' => 'Kambing Jantan', 'genre_id' => 2, 'author_id' => 5, 'tahun_terbit' => 2005, 'harga' => 65000],
        ];

        foreach ($books as $book) {
            Book::create($book);
        }
    }
}