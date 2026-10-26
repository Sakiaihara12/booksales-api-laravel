<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Author;

class AuthorSeeder extends Seeder
{
    public function run(): void
    {
        $authors = [
            ['nama_author' => 'Tere Liye', 'negara' => 'Indonesia'],
            ['nama_author' => 'Pramoedya Ananta Toer', 'negara' => 'Indonesia'],
            ['nama_author' => 'Dewi Lestari', 'negara' => 'Indonesia'],
            ['nama_author' => 'Andrea Hirata', 'negara' => 'Indonesia'],
            ['nama_author' => 'Raditya Dika', 'negara' => 'Indonesia'],
        ];

        foreach ($authors as $author) {
            Author::create($author);
        }
    }
}