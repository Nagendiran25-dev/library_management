<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\BookBorrowRequest;
use App\Http\Requests\GetAllBorrowedDetailsRequest;
use App\Services\BookService;
use App\Services\BookBorrowedService;
use App\Classes\ApiResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
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
    public function borrowBook(BookBorrowRequest $request)
    {
        DB::beginTransaction();
        try{
            $data = $request->validated();
            $borrowBook = $this->bookBorrowedService->borrowBook($data);
            DB::commit();
            return ApiResponse::sendResponse($borrowBook,'Book Borrowed Successfully',201);
        }catch(\Exception $ex){
            return ApiResponse::rollback($ex);
        }
    }
    public function returnBorrowBook(BookBorrowRequest $request)
    {
        DB::beginTransaction();
        try{
            $data = $request->validated();
            $response = $this->bookBorrowedService->returnBorrowBook($data);
            DB::commit();
           // Check the status of the return and send appropriate response
            if ($response['status'] == 'overdue') {
                // Return fine details if the book is overdue
                unset($response['status']);
                return ApiResponse::sendResponse($response, 'Book is overdue', 200);
            } else {
                // Return success message if the book is returned without fine
                return ApiResponse::sendResponse($response, $response['message'], 200);
            }
        }catch(\Exception $ex){
            return ApiResponse::rollback($ex);
        }
    }
    public function getUserBorrowedBooks(Request $request)
    {
        $rules = [
            'user_id' => 'required|integer|exists:users,id', 
            'per_page' => 'nullable|integer|min:1',
        ];    
        // Validate the request data
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            // Return a custom error response
            return ApiResponse::sendResponse($validator->errors(),'Validation errors',400,false);
        }
        $perPage = $request->get('per_page', 10); // Get the per_page query parameter, default to 10
        $user_id= $request->get('user_id');
        $userBorrowedBooks = $this->bookBorrowedService->getUserBorrowedBooks($user_id, $perPage);
        return ApiResponse::sendResponse($userBorrowedBooks,'Borrowed Books Details!',200);
    }
    public function getAllBorrwedDetails(GetAllBorrowedDetailsRequest $request)
    {
        $data = $request->validated();
        $response = $this->bookBorrowedService->getAllBorrwedDetails($data);
        return ApiResponse::sendResponse($response,'List All Borrowed Books Details!',200);
    }
}
