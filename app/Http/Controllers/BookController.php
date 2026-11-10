<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class BookController extends Controller
{
    // Aturan validasi dipakai bersama oleh store dan update
    private function rules(): array
    {
        return [
            'judul_buku'   => 'required|string|max:255',
            'genre_id'     => 'required|exists:genres,id',
            'author_id'    => 'required|exists:authors,id',
            'tahun_terbit' => 'required|integer',
            'harga'        => 'required|numeric|min:0',
            'stock'        => 'required|integer|min:0',
            'deskripsi'    => 'nullable|string',
            'cover'        => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ];
    }

    private function validationError($validator)
    {
        return response()->json([
            'success' => false,
            'message' => 'Validation Error',
            'errors'  => $validator->errors(),
        ], 422);
    }

    // Menampilkan semua data buku (Read All)
    public function index()
    {
        $books = Book::with(['author', 'genre'])->latest()->get();

        return response()->json([
            'success' => true,
            'message' => 'List Data Books',
            'data'    => $books,
        ], 200);
    }

    // Buku terlaris (berdasarkan jumlah terjual di tabel transactions)
    // Butuh relasi transactions() di model Book. Route-nya harus didaftarkan SEBELUM /books/{book}.
    public function popular()
    {
        $books = Book::with(['author', 'genre'])
            ->withSum('transactions as total_terjual', 'quantity')
            ->orderByDesc('total_terjual')
            ->latest('id')
            ->take(8)
            ->get();

        return response()->json([
            'success' => true,
            'message' => 'Buku Terlaris',
            'data'    => $books,
        ], 200);
    }

    // Menampilkan detail satu buku
    public function show(Book $book)
    {
        return response()->json([
            'success' => true,
            'message' => 'Detail Data Book',
            'data'    => $book->load(['author', 'genre']),
        ], 200);
    }

    // Menambah data buku baru (Store)
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), $this->rules());

        if ($validator->fails()) {
            return $this->validationError($validator);
        }

        $data = $validator->validated();

        if ($request->hasFile('cover')) {
            // Disimpan di storage/app/public/covers -> diakses lewat /storage/covers/...
            $data['cover'] = $request->file('cover')->store('covers', 'public');
        }

        $book = Book::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Book Created Successfully',
            'data'    => $book->load(['author', 'genre']),
        ], 201);
    }

    // Mengubah data buku (Update)
    // Frontend mengirim POST + _method=PUT karena ada upload file.
    public function update(Request $request, Book $book)
    {
        $validator = Validator::make($request->all(), $this->rules());

        if ($validator->fails()) {
            return $this->validationError($validator);
        }

        $data = $validator->validated();

        if ($request->hasFile('cover')) {
            // Hapus cover lama supaya storage tidak menumpuk
            if ($book->cover) {
                Storage::disk('public')->delete($book->cover);
            }
            $data['cover'] = $request->file('cover')->store('covers', 'public');
        } else {
            // Tidak upload cover baru: pertahankan cover yang lama
            unset($data['cover']);
        }

        $book->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Book Updated Successfully',
            'data'    => $book->load(['author', 'genre']),
        ], 200);
    }

    // Menghapus buku (Destroy)
    public function destroy(Book $book)
    {
        try {
            $book->delete();
        } catch (QueryException $e) {
            // Buku sudah dipakai di transaksi (foreign key)
            return response()->json([
                'success' => false,
                'message' => 'Buku sudah pernah dibeli (ada di transaksi) sehingga tidak bisa dihapus',
            ], 409);
        }

        if ($book->cover) {
            Storage::disk('public')->delete($book->cover);
        }

        return response()->json([
            'success' => true,
            'message' => 'Book Deleted Successfully',
        ], 200);
    }
}
