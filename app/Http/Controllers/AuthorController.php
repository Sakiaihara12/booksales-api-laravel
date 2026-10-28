<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Author;

class AuthorController extends Controller
{
    // 1. Read all data author
    public function index()
    {
        $authors = Author::all();
        return response()->json([
            'success' => true,
            'message' => 'List Data Author',
            'data' => $authors
        ], 200);
    }

    // 2. Create data author
    public function store(Request $request)
    {
        $request->validate([
            'nama_author' => 'required|string|max:255',
            'negara' => 'required|string|max:255',
        ]);

        $author = Author::create([
            'nama_author' => $request->nama_author,
            'negara' => $request->negara,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Data Author Berhasil Ditambahkan',
            'data' => $author
        ], 201);
    }
}