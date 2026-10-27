<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookStoreController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Tambahkan rute API Bookstore di bawah sini:
Route::get('/books', [BookStoreController::class, 'index']);
Route::get('/genres', [BookStoreController::class, 'indexGenre']);
Route::get('/authors', [BookStoreController::class, 'indexAuthor']);