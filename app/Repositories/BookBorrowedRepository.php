<?php
namespace App\Repositories;

use App\Models\Book;
use App\Models\BorrowedBook;
use Carbon\Carbon;
use App\Repositories\Contracts\BookBorrowedRepositoryInterface;

class BookBorrowedRepository implements BookBorrowedRepositoryInterface
{
    public function getUserBorrowedBooks($user_id,$perPage)
    {
        // Query BorrowedBook with a join to the Book model
        $query = BorrowedBook::query()
        ->join('books', 'borrowed_books.book_id', '=', 'books.id') // Join the books table
        ->where('borrowed_books.user_id', $user_id) // Filter by user_id
        ->select([
            'borrowed_books.*',
            'books.title',
            'books.author', 
            'books.published_date',    
            'books.description',  
        ]);
        // Paginate the results
        return $query->paginate($perPage);
    }
    public function borrowBook(array $data)
    {
        $book = Book::findOrFail($data['book_id']);
        $book->update(['status'=>1]);
        return BorrowedBook::create($data);
    }

    public function returnBorrowBook(array $data)
    {
        $book = Book::findOrFail($data['book_id']);
        $book->update(['status'=>0]);
        $BorrowedBook = BorrowedBook::findOrFail($data['borrowed_id']);
        $BorrowedBook->update($data);
        return $BorrowedBook;
    }
    public function getBorrowedDetails($id)
    {
        return BorrowedBook::findOrFail($id);
    }
    public function getAllBorrwedDetails(array $data)
    {
        $query = BorrowedBook::query();

        // Apply filters based on input data
        if (!empty($data['user_id'])) {
            $query->where('user_id', $data['user_id']);
        }

        if (!empty($data['user_email'])) {
            $query->whereHas('user', function ($q) use ($data) {
                $q->where('email', $data['user_email']);
            });
        }

        if (!empty($data['due_date_from'])) {
            $query->whereDate('due_date', '>=', Carbon::parse($data['due_date_from']));
        }

        if (!empty($data['due_date_to'])) {
            $query->whereDate('due_date', '<=', Carbon::parse($data['due_date_to']));
        }

        if (!empty($data['borrow_status'])) {
            $query->where('status', $data['borrow_status']);
        }

        if (!empty($data['user_status'])) {
            $query->whereHas('user', function ($q) use ($data) {
                $q->where('status', $data['user_status']);
            });
        }

        if (!empty($data['return_date_from'])) {
            $query->whereDate('return_date', '>=', Carbon::parse($data['return_date_from']));
        }

        if (!empty($data['return_date_to'])) {
            $query->whereDate('return_date', '<=', Carbon::parse($data['return_date_to']));
        }

        // Fetch the relational data also
        return $query->with(['book', 'user'])->paginate($data['per_page']);
    }

}
