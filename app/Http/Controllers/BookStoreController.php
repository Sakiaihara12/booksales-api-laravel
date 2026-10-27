<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Genre;
use App\Models\Author;
use App\Models\Book;

class BookStoreController extends Controller
{
    // Mengembalikan data genre dalam format JSON
    public function indexGenre()
    {
        $genres = Genre::all();
        
        return response()->json([
            'success' => true,
            'message' => 'List Data Genre',
            'data' => $genres
        ], 200);
    }

    // Mengembalikan data author dalam format JSON
    public function indexAuthor()
    {
        $authors = Author::all();
        
        return response()->json([
            'success' => true,
            'message' => 'List Data Author',
            'data' => $authors
        ], 200);
    }

    // Mengembalikan data buku beserta relasinya dalam format JSON
    public function index()
    {
        $books = Book::with(['genre', 'author'])->get();
        
        return response()->json([
            'success' => true,
            'message' => 'List Data Buku',
            'data' => $books
        ], 200);
    }
}