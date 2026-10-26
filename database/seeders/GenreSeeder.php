<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Genre; // Pastikan Model Genre di-import

class GenreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $genres = [
            ['nama_genre' => 'Fiksi', 'keterangan' => 'Novel dan cerita imajinatif'],
            ['nama_genre' => 'Non-Fiksi', 'keterangan' => 'Buku berdasarkan fakta dan riset'],
            ['nama_genre' => 'Teknologi', 'keterangan' => 'Buku pemrograman dan ilmu komputer'],
            ['nama_genre' => 'Fantasi', 'keterangan' => 'Cerita dengan elemen sihir dan dunia magis'],
            ['nama_genre' => 'Sejarah', 'keterangan' => 'Catatan peristiwa dan peradaban masa lalu'],
        ];

        foreach ($genres as $genre) {
            Genre::create($genre);
        }
    }
}