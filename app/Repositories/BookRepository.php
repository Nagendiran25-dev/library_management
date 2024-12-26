<?php
namespace App\Repositories;

use App\Models\Book;
use App\Repositories\Contracts\BookRepositoryInterface;

class BookRepository implements BookRepositoryInterface
{
    public function getBooksByStatus($status,$perPage)
    {
        $query = Book::query(); // Start a query builder instance

        if (!is_null($status)) {
            $query->where('status', $status); // Filter by status if provided
        }
    
        return $query->paginate($perPage); // Paginate the results
    }

    public function getBookById($id)
    {
        return Book::findOrFail($id);
    }

    public function createBook(array $data)
    {
        return Book::create($data);
    }

    public function updateBook($id, array $data)
    {
        $book = Book::findOrFail($id);
        $book->update($data);
        return $book;
    }
    
    public function deleteBook($id)
    {
        $book = Book::findOrFail($id);
        $book->delete();
    }

}
