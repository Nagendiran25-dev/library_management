<?php
namespace App\Repositories;

use App\Models\Book;
use App\Models\BorrowedBook;
use App\Repositories\Contracts\BookBorrowedRepositoryInterface;

class BookBorrowedRepository implements BookBorrowedRepositoryInterface
{
    public function getUserBorrowedBooks($user_id,$perPage)
    {
        $query = BorrowedBook::query(); // Start a query builder instance
        $query->where('user_id', $user_id);
        return $query->paginate($perPage); // Paginate the results
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
        $BorrowedBook = BorrowedBook::findOrFail($data['id']);
        $BorrowedBook->update($data);
        return $book;
    }
    
    public function payFinesReturnBorrowBook(array $data)
    {
        $book = Book::findOrFail($id);
        $book->delete();
    }
 

}
