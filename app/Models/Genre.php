<?php

namespace App\Models;

class Genre
{
    public static function all()
    {
        return [
            ['id' => 1, 'nama_genre' => 'Fiksi', 'keterangan' => 'Novel dan cerita imajinatif'],
            ['id' => 2, 'nama_genre' => 'Non-Fiksi', 'keterangan' => 'Buku berdasarkan fakta dan riset'],
            ['id' => 3, 'nama_genre' => 'Teknologi', 'keterangan' => 'Buku pemrograman dan ilmu komputer'],
            ['id' => 4, 'nama_genre' => 'Fantasi', 'keterangan' => 'Cerita dengan elemen sihir dan dunia magis'],
            ['id' => 5, 'nama_genre' => 'Sejarah', 'keterangan' => 'Catatan peristiwa dan peradaban masa lalu'],
        ];
    }
}