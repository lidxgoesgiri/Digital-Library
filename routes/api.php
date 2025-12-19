<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BookController;
use App\Http\Controllers\Api\BorrowingController;
use Illuminate\Support\Facades\Route;

// Public routes
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login/google', [AuthController::class, 'loginWithGoogle']);

// Protected routes (user only)
Route::middleware(['auth:sanctum', 'user'])->group(function () {
    // Auth
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', [AuthController::class, 'user']);
    
    // Books
    Route::get('/books', [BookController::class, 'index']);
    Route::get('/books/{book}', [BookController::class, 'show']);
    
    // Borrowings
    Route::get('/borrowings', [BorrowingController::class, 'index']);
    Route::post('/books/{book}/borrow', [BorrowingController::class, 'borrow']);
    Route::post('/borrowings/{borrowing}/return', [BorrowingController::class, 'returnBook']);
});
