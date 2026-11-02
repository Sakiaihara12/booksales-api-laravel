<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BookController extends Controller
{
    // Menampilkan semua data buku (Read All)
    public function index()
    {
        $books = Book::with(['author', 'genre'])->latest()->get();

        return response()->json([
            'success' => true,
            'message' => 'List Data Books',
            'data' => $books
        ], 200);
    }

    // Menambah data buku baru (Store)
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'judul_buku'   => 'required|string|max:255',
            'genre_id'     => 'required|exists:genres,id',
            'author_id'    => 'required|exists:authors,id',
            'tahun_terbit' => 'required|integer',
            'harga'        => 'required|numeric|min:0',
            'stock'        => 'required|integer|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation Error',
                'errors' => $validator->errors()
            ], 422);
        }

        $book = Book::create([
            'judul_buku'   => $request->judul_buku,
            'genre_id'     => $request->genre_id,
            'author_id'    => $request->author_id,
            'tahun_terbit' => $request->tahun_terbit,
            'harga'        => $request->harga,
            'stock'        => $request->stock,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Book Created Successfully',
            'data' => $book
        ], 201);
    }
}