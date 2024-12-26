<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Services\BookService;
use App\Http\Requests\BookRequest;
use Illuminate\Http\Request;
use App\Classes\ApiResponse;
class BookController extends Controller
{
    protected $bookService;

    public function __construct(BookService $bookService)
    {
        $this->bookService = $bookService;
    }

    public function index(Request $request)
    {
        $status = $request->get('status'); // Get the status query parameter, if provided
        $perPage = $request->get('per_page', 10); // Get the per_page query parameter, default to 10
        $books = $this->bookService->getBooksByStatus($status, $perPage);
        return ApiResponse::sendResponse($books,'List All Books Details!',200);
    }

    public function show($id)
    {
        
        try {
            return ApiResponse::sendResponse($this->bookService->getBookById($id),'Books Details!',200);
        } catch (\Exception $ex) {
            return ApiResponse::throw($ex);
        }
    }

    public function store(BookRequest $request)
    {
        try {
            $data = $request->validated();
            return ApiResponse::sendResponse($this->bookService->createBook($data),'Book added successfully!',201);
        } catch (\Exception $ex) {
            return ApiResponse::throw($ex);
        }
    }

    public function update(BookRequest $request, $id)
    {
        try {
            $data = $request->validated();
            return ApiResponse::sendResponse($this->bookService->updateBook($id, $data),'Book details updated successfully!',200);
        } catch (\Exception $ex) {
            return ApiResponse::throw($ex);
        }
    }

    public function destroy($id)
    {
       try {
            $result =$this->bookService->deleteBook($id);
            if($result)
                return ApiResponse::sendResponse([],'Book deleted successfully!',200);
            else
                return ApiResponse::sendResponse([], 'Book currently borrowed, so cannot be deleted', 400,false);
        } catch (\Exception $ex) {
            return ApiResponse::throw($ex);
        }
    }
}
