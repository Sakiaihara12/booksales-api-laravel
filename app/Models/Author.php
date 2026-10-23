<?php

namespace App\Models;

class Author
{
    public static function all()
    {
        return [
            ['id' => 1, 'nama_author' => 'Tere Liye', 'negara' => 'Indonesia'],
            ['id' => 2, 'nama_author' => 'Pramoedya Ananta Toer', 'negara' => 'Indonesia'],
            ['id' => 3, 'nama_author' => 'Dewi Lestari', 'negara' => 'Indonesia'],
            ['id' => 4, 'nama_author' => 'Andrea Hirata', 'negara' => 'Indonesia'],
            ['id' => 5, 'nama_author' => 'Raditya Dika', 'negara' => 'Indonesia'],
        ];
    }
}