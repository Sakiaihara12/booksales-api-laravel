<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Author;

class AuthorController extends Controller
{
    // Read all data author
    public function index()
    {
        $authors = Author::all();
        return response()->json([
            'success' => true,
            'message' => 'List Data Author',
            'data' => $authors
        ], 200);
    }

    // Create data author
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

    // Show specific data author by ID
    public function show($id)
    {
        $author = Author::find($id);

        if (!$author) {
            return response()->json([
                'success' => false,
                'message' => 'Data Author tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Detail Data Author',
            'data' => $author
        ], 200);
    }

    // Update data author
    public function update(Request $request, $id)
    {
        $author = Author::find($id);

        if (!$author) {
            return response()->json([
                'success' => false,
                'message' => 'Data Author tidak ditemukan untuk diubah'
            ], 404);
        }

        $request->validate([
            'nama_author' => 'required|string|max:255',
            'negara' => 'required|string|max:255',
        ]);

        $author->update([
            'nama_author' => $request->nama_author,
            'negara' => $request->negara,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Data Author Berhasil Diubah',
            'data' => $author
        ], 200);
    }

    // Delete data author
    public function destroy($id)
    {
        $author = Author::find($id);

        if (!$author) {
            return response()->json([
                'success' => false,
                'message' => 'Data Author tidak ditemukan untuk dihapus'
            ], 404);
        }

        $author->delete();

        return response()->json([
            'success' => true,
            'message' => 'Data Author Berhasil Dihapus'
        ], 200);
    }
}