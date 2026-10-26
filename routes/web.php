<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookStoreController;

Route::get('/books', [BookStoreController::class, 'index']);
Route::get('/genres', [BookStoreController::class, 'indexGenre']);
Route::get('/authors', [BookStoreController::class, 'indexAuthor']);
Route::get('/', function () {
    return view('welcome');
});
