<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// ==========================================
// 1. PUBLIC ROUTES (Bebas diakses)
// ==========================================

// Books Public (Index & Show)
Route::get('/books', [BookController::class, 'index']);
Route::get('/books/popular', [BookController::class, 'popular']);
Route::get('/books/{book}', [BookController::class, 'show']);

// Genre Public (Index & Show)
Route::get('/genres', [GenreController::class, 'index']);
Route::get('/genres/{genre}', [GenreController::class, 'show']);

// Author Public (Index & Show)
Route::get('/authors', [AuthorController::class, 'index']);
Route::get('/authors/{author}', [AuthorController::class, 'show']);

// Auth
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);


// ==========================================
// 2. CUSTOMER AUTH ROUTES (Transaksi untuk Customer)
// ==========================================
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/transactions', [TransactionController::class, 'store']);
    Route::put('/transactions/{id}', [TransactionController::class, 'update']);
    Route::get('/transactions/{id}', [TransactionController::class, 'show']);
    Route::get('/my-transactions', [TransactionController::class, 'myTransactions']);
});


// ==========================================
// 3. ADMIN ROUTES (Khusus Admin: Store, Update, Destroy)
// ==========================================
Route::middleware(['auth:sanctum', 'is.admin'])->group(function () {

    // Books Admin
    Route::post('/books', [BookController::class, 'store']);
    Route::put('/books/{book}', [BookController::class, 'update']);
    Route::delete('/books/{book}', [BookController::class, 'destroy']);

    // Genre Admin
    Route::post('/genres', [GenreController::class, 'store']);
    Route::put('/genres/{genre}', [GenreController::class, 'update']);
    Route::delete('/genres/{genre}', [GenreController::class, 'destroy']);

    // Author Admin
    Route::post('/authors', [AuthorController::class, 'store']);
    Route::put('/authors/{author}', [AuthorController::class, 'update']);
    Route::delete('/authors/{author}', [AuthorController::class, 'destroy']);

    // Transactions Admin
    Route::get('/transactions', [TransactionController::class, 'index'])->name('admin.transactions');
    Route::delete('/transactions/{id}', [TransactionController::class, 'destroy']);

    Route::get('/users', [UserController::class, 'index']);
Route::get('/users/{user}', [UserController::class, 'show']);
Route::put('/users/{user}', [UserController::class, 'update']);
Route::delete('/users/{user}', [UserController::class, 'destroy']);
});
