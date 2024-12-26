<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthenticationController;
use App\Http\Controllers\API\BookController;
use App\Http\Controllers\API\BorrowedBookController;
use App\Http\Controllers\API\UserController;

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
    Route::middleware(['auth:sanctum', 'is.user'])->group(function () {
        
        // View Books
        Route::get('books', [BorrowedBookController::class, 'getAvailableBooks']);
        
        // Borrow and Return Books
        Route::post('book-borrow', [BorrowedBookController::class, 'borrowBook'])->defaults('type', 'borrow');
        Route::post('book-return', [BorrowedBookController::class, 'returnBorrowBook'])->defaults('type', 'return');
        
        // View Borrowed Books
        Route::get('borrowed-books', [BorrowedBookController::class, 'getUserBorrowedBooks']);
        
    });
});

// Admin

Route::prefix('admin')->group(function () {
    // Authentication protected routes
    Route::post('login', [AuthenticationController::class, 'login'])->defaults('role', 'admin');
    Route::post('register', [AuthenticationController::class, 'register'])->defaults('role', 'admin');

    Route::middleware(['auth:sanctum', 'is.admin'])->group(function () {
        // Manage Books
        Route::resource('books', BookController::class);

        //Manage Users
        Route::get('view-users', [UserController::class, 'getAllUsers']);
        Route::post('updateuser-status', [UserController::class, 'updateUserStatus']);
        
        // Track the Borrowed Details
        Route::get('get_all_borrowed_books', [BorrowedBookController::class, 'getAllBorrwedDetails']);
    });
});

