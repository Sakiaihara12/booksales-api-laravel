<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\AuthController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// ==========================================
// 1. PUBLIC ROUTES (Bebas diakses)
// ==========================================
// (GET /books sudah dipindah ke Admin routes)

// Genre Public (Index & Show)
Route::get('/genres', [GenreController::class, 'index']);
Route::get('/genres/{genre}', [GenreController::class, 'show']);

// Author Public (Index & Show)
Route::get('/authors', [AuthorController::class, 'index']);
Route::get('/authors/{author}', [AuthorController::class, 'show']);

// Auth Login
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);


// ==========================================
// 2. CUSTOMER AUTH ROUTES (Transaksi untuk Customer)
// ==========================================
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/transactions', [TransactionController::class, 'store']);       
    Route::put('/transactions/{id}', [TransactionController::class, 'update']);   
    Route::get('/transactions/{id}', [TransactionController::class, 'show']);    
});


// ==========================================
// 3. ADMIN ROUTES (Khusus Admin: Read All, Store, Update, Destroy)
// ==========================================
Route::middleware(['auth:sanctum', 'is.admin'])->group(function () {

    // Books Admin (Read All, Store, Update, Destroy)
    Route::get('/books', [BookController::class, 'index']);          // Read All dipindah ke sini
    Route::post('/books', [BookController::class, 'store']);         
    Route::put('/books/{book}', [BookController::class, 'update']);  
    Route::delete('/books/{book}', [BookController::class, 'destroy']); // Destroy khusus admin

    // Genre Admin (Store, Update, Destroy)
    Route::post('/genres', [GenreController::class, 'store']);
    Route::put('/genres/{genre}', [GenreController::class, 'update']);
    Route::delete('/genres/{genre}', [GenreController::class, 'destroy']);

    // Author Admin (Store, Update, Destroy)
    Route::post('/authors', [AuthorController::class, 'store']);
    Route::put('/authors/{author}', [AuthorController::class, 'update']);
    Route::delete('/authors/{author}', [AuthorController::class, 'destroy']);

    // Transactions Admin
    Route::get('/transactions', [TransactionController::class, 'transactions'])->name('admin.transactions'); // Sesuaikan nama method jika diperlukan        
    Route::delete('/transactions/{id}', [TransactionController::class, 'destroy']); 
});