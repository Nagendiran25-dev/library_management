<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthenticationController;
use App\Http\Controllers\API\BookController;
use App\Http\Controllers\API\BorrowedBookController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::prefix('user')->group(function () {

    // Registration and Login
    Route::post('register', [AuthenticationController::class, 'register'])->defaults('role', 'user');
    Route::post('login', [AuthenticationController::class, 'login'])->defaults('role', 'user');

    // Authentication protected routes
    Route::middleware('auth:sanctum')->group(function () {
        
        // View Books
        Route::get('books', [BorrowedBookController::class, 'getAvailableBooks']);
        
        // Borrow and Return Books
        Route::post('book-borrow', [BorrowedBookController::class, 'borrowBook']);
        Route::post('book-return', [BorrowedBookController::class, 'return']);
        
        // View Borrowed Books
        Route::get('borrowed-books', [BorrowedBookController::class, 'getUserBorrowedBooks']);
        
        // Pay Fines
        Route::post('pay-fine', [BorrowedBookController::class, 'payFine']);
    });
});

// Admin

Route::prefix('admin')->group(function () {
    // Authentication protected routes
    Route::post('login', [AuthenticationController::class, 'login'])->defaults('role', 'admin');
    Route::post('register', [AuthenticationController::class, 'register'])->defaults('role', 'admin');
    Route::middleware(['auth:sanctum', 'is.admin'])->group(function () {

        Route::resource('books', BookController::class);
            // Route::get('/', [BookController::class, 'index']); // Fetch all books
            // Route::get('/{id}', [BookController::class, 'show']); // Fetch a single book
            // Route::post('/', [BookController::class, 'store']); // Create a book
            // Route::put('/{id}', [BookController::class, 'update']); // Update a book
            // Route::delete('/{id}', [BookController::class, 'destroy']); // Delete a book
        
    });
});

