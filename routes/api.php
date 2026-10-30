<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\AuthorController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// ==========================================
// 1. PUBLIC ROUTES
// ==========================================
Route::get('/books', [BookController::class, 'index']);

// Genre Public (Index & Show)
Route::get('/genres', [GenreController::class, 'index']);
Route::get('/genres/{genre}', [GenreController::class, 'show']);

// Author Public (Index & Show)
Route::get('/authors', [AuthorController::class, 'index']);
Route::get('/authors/{author}', [AuthorController::class, 'show']);


// ==========================================
// 2. ADMIN ONLY ROUTES
// ==========================================
Route::middleware('auth:sanctum')->group(function () {

    // Genre Admin (Store, Update, Destroy)
    Route::post('/genres', [GenreController::class, 'store']);
    Route::put('/genres/{genre}', [GenreController::class, 'update']);
    Route::delete('/genres/{genre}', [GenreController::class, 'destroy']);

    // Author Admin (Store, Update, Destroy)
    Route::post('/authors', [AuthorController::class, 'store']);
    Route::put('/authors/{author}', [AuthorController::class, 'update']);
    Route::delete('/authors/{author}', [AuthorController::class, 'destroy']);

});