<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\BookBorrowRequest;
use App\Services\BookService;
use App\Services\BookBorrowedService;
use App\Classes\ApiResponse;
class BorrowedBookController extends Controller
{
    protected $bookService;

    public function __construct(BookService $bookService,BookBorrowedService $bookBorrowedService)
    {
        $this->bookService = $bookService;
        $this->bookBorrowedService = $bookBorrowedService;
    }
    
    public function getAvailableBooks(Request $request)
    {
        $perPage = $request->get('per_page', 10); // Get the per_page query parameter, default to 10
        $books = $this->bookService->getBooksByStatus(0, $perPage);
        return ApiResponse::sendResponse($books,'List All Books Details!',200);
    }

    public function getUserBorrowedBooks(Request $request)
    {
        $perPage = $request->get('per_page', 10); // Get the per_page query parameter, default to 10
        $user_id= $request->get('user_id');
        $userBorrowedBooks = $this->bookBorrowedService->getUserBorrowedBooks($user_id, $perPage);
        return ApiResponse::sendResponse($userBorrowedBooks,'List All Borrowed Books Details!',200);
    }

    public function borrowBook(BookBorrowRequest $request)
    {
        $borrowBook = $this->bookBorrowedService->borrowBook($perPage);
        return ApiResponse::sendResponse($borrowBook,'List All Borrowed Books Details!',200);
    }
    public function returnBorrowBook(BookBorrowRequest $request)
    {

    }
    

}
