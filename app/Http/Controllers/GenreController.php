<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Genre;

class GenreController extends Controller
{
    // Read all data genre
    public function index()
    {
        $genres = Genre::all();
        return response()->json([
            'success' => true,
            'message' => 'List Data Genre',
            'data' => $genres
        ], 200);
    }

    // Create data genre
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

    // Show specific data genre by ID
    public function show($id)
    {
        $genre = Genre::find($id);

        if (!$genre) {
            return response()->json([
                'success' => false,
                'message' => 'Data Genre tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Detail Data Genre',
            'data' => $genre
        ], 200);
    }

    // Update data genre
    public function update(Request $request, $id)
    {
        $genre = Genre::find($id);

        if (!$genre) {
            return response()->json([
                'success' => false,
                'message' => 'Data Genre tidak ditemukan untuk diubah'
            ], 404);
        }

        $request->validate([
            'nama_genre' => 'required|string|max:255',
            'keterangan' => 'nullable|string',
        ]);

        $genre->update([
            'nama_genre' => $request->nama_genre,
            'keterangan' => $request->keterangan,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Data Genre Berhasil Diubah',
            'data' => $genre
        ], 200);
    }

    // Delete data genre
    public function destroy($id)
    {
        $genre = Genre::find($id);

        if (!$genre) {
            return response()->json([
                'success' => false,
                'message' => 'Data Genre tidak ditemukan untuk dihapus'
            ], 404);
        }

        $genre->delete();

        return response()->json([
            'success' => true,
            'message' => 'Data Genre Berhasil Dihapus'
        ], 200);
    }
}