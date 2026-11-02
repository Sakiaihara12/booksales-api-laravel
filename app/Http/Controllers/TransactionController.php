<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TransactionController extends Controller
{
    // Menampilkan semua data transaksi (beserta relasi user dan book)
    public function index()
    {
        $transactions = Transaction::with(['user', 'book'])->latest()->get();

        return response()->json([
            'success' => true,
            'message' => 'List Data Transactions',
            'data' => $transactions
        ], 200);
    }

    // Menyimpan transaksi baru (Sesuai 8 poin alur logika dosen)
    public function store(Request $request)
    {
        // 1. validator & cek validator
        $validator = Validator::make($request->all(), [
            'book_id'  => 'required|exists:books,id',
            'quantity' => 'required|integer|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation Error',
                'errors' => $validator->errors()
            ], 422);
        }

        // 2. generate orderNumber -> unique | ORD-0003
        $lastTransaction = Transaction::latest()->first();
        $lastNumber = $lastTransaction ? intval(substr($lastTransaction->order_number, 4)) : 0;
        $orderNumber = 'ORD-' . str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);

        // 3. ambil user yang sedang login & cek login (apakah ada data user?)
        $user = $request->user();
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized - User not logged in'
            ], 401);
        }

        // 4. mencari data buku dari request
        $book = Book::find($request->book_id);

        // 5. cek stok buku
        if ($book->stock < $request->quantity) {
            return response()->json([
                'success' => false,
                'message' => 'Stock is not enough / Out of stock'
            ], 400);
        }

        // 6. hitung total harga = price * quantity
        $totalAmount = $book->price * $request->quantity;

        // 7. kurangi stok buku (update)
        $book->stock -= $request->quantity;
        $book->save();

        // 8. simpan data transaksi
        $transaction = Transaction::create([
            'order_number' => $orderNumber,
            'customer_id'  => $user->id, // Sesuaikan dengan foreign key di database-mu (customer_id atau user_id)
            'book_id'      => $book->id,
            'quantity'     => $request->quantity,
            'total_amount' => $totalAmount,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Transaction Created Successfully',
            'data' => $transaction->load(['user', 'book'])
        ], 201);
    }

    // Menampilkan detail satu transaksi tertentu
    public function show($id)
    {
        $transaction = Transaction::with(['user', 'book'])->find($id);

        if (!$transaction) {
            return response()->json([
                'success' => false,
                'message' => 'Transaction Not Found',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Detail Data Transaction',
            'data' => $transaction
        ], 200);
    }

    // Menghapus data transaksi
    public function destroy($id)
    {
        $transaction = Transaction::find($id);

        if (!$transaction) {
            return response()->json([
                'success' => false,
                'message' => 'Transaction Not Found',
            ], 404);
        }

        $transaction->delete();

        return response()->json([
            'success' => true,
            'message' => 'Transaction Deleted Successfully',
        ], 200);
    }

    // Mengubah / Update data transaksi
public function update(Request $request, $id)
{
    $transaction = Transaction::find($id);

    if (!$transaction) {
        return response()->json([
            'success' => false,
            'message' => 'Transaction Not Found',
        ], 404);
    }

    // 1. Validasi input
    $validator = Validator::make($request->all(), [
        'book_id'  => 'required|exists:books,id',
        'quantity' => 'required|integer|min:1',
    ]);

    if ($validator->fails()) {
        return response()->json([
            'success' => false,
            'message' => 'Validation Error',
            'errors' => $validator->errors()
        ], 422);
    }

    $oldBookId = $transaction->book_id;
    $oldQuantity = $transaction->quantity;

    $newBookId = $request->book_id;
    $newQuantity = $request->quantity;

    $newBook = Book::find($newBookId);

    // 2. Logika penyesuaian stok saat update
    if ($oldBookId == $newBookId) {
        // Jika bukunya sama, hitung selisih quantity
        $diffQuantity = $newQuantity - $oldQuantity; 
        
        if ($diffQuantity > 0) {
            // Jika quantity bertambah, pastikan stok mencukupi
            if ($newBook->stock < $diffQuantity) {
                return response()->json([
                    'success' => false,
                    'message' => 'Stock is not enough for update'
                ], 400);
            }
            $newBook->stock -= $diffQuantity;
        } else {
            // Jika quantity berkurang, kembalikan selisih stok ke database
            $newBook->stock += abs($diffQuantity);
        }
        $newBook->save();
    } else {
        // Jika bukunya diganti:
        // Kembalikan stok buku lama terlebih dahulu
        $oldBook = Book::find($oldBookId);
        if ($oldBook) {
            $oldBook->stock += $oldQuantity;
            $oldBook->save();
        }

        // Cek dan kurangi stok buku yang baru
        if ($newBook->stock < $newQuantity) {
            return response()->json([
                'success' => false,
                'message' => 'Stock is not enough for the new book'
            ], 400);
        }
        $newBook->stock -= $newQuantity;
        $newBook->save();
    }

    // 3. Hitung ulang total harga
    $totalAmount = $newBook->price * $newQuantity;

    // 4. Update data transaksi di database
    $transaction->update([
        'book_id'      => $newBookId,
        'quantity'     => $newQuantity,
        'total_amount' => $totalAmount,
    ]);

    return response()->json([
        'success' => true,
        'message' => 'Transaction Updated Successfully',
        'data' => $transaction->load(['user', 'book'])
    ], 200);
}
}