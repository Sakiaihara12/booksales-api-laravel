<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Genre;

class GenreController extends Controller
{
    // 1. Read all data genre
    public function index()
    {
        $genres = Genre::all();
        return response()->json([
            'success' => true,
            'message' => 'List Data Genre',
            'data' => $genres
        ], 200);
    }

    // 2. Create data genre
    public function store(Request $request)
    {
        $request->validate([
            'nama_genre' => 'required|string|max:255',
            'keterangan' => 'nullable|string',
        ]);

        $genre = Genre::create([
            'nama_genre' => $request->nama_genre,
            'keterangan' => $request->keterangan,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Data Genre Berhasil Ditambahkan',
            'data' => $genre
        ], 201);
    }
}