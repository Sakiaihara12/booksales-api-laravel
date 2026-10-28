<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;

class BookController extends Controller
{
    // Read all data buku beserta relasinya
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