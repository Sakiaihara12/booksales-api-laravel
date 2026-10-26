<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Genre;
use App\Models\Author;
use App\Models\Book;

class BookStoreController extends Controller
{
    public function indexGenre()
    {
        // Mengambil data dari Model Genre
        $genres = Genre::all();
        
        // Mengirim data ke View
        return view('genres', compact('genres'));
    }

    public function indexAuthor()
    {
        // Mengambil data dari Model Author
        $authors = Author::all();
        
        // Mengirim data ke View
        return view('authors', compact('authors'));
    }

public function index()
{
    $books = Book::with(['genre', 'author'])->get();
    return view('books', compact('books'));
}
}