<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    // Relasi: Buku milik satu Genre
    public function genre()
    {
        return $this->belongsTo(Genre::class);
    }

    // Relasi: Buku ditulis oleh satu Author
    public function author()
    {
        return $this->belongsTo(Author::class);
    }
}