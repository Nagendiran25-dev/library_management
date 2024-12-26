<?php

namespace App\Services;

use App\Repositories\Contracts\BookRepositoryInterface;

class BookService
{
    protected $bookRepository;

    public function __construct(BookRepositoryInterface $bookRepository)
    {
        $this->bookRepository = $bookRepository;
    }

    public function getBooksByStatus($status,$perPage)
    {
        return $this->bookRepository->getBooksByStatus($status,$perPage);
    }

    public function getBookById($id)
    {
        return $this->bookRepository->getBookById($id);
    }

    public function createBook(array $data)
    {
        return $this->bookRepository->createBook($data);
    }

    public function updateBook($id, array $data)
    {
        return $this->bookRepository->updateBook($id, $data);
    }

    public function deleteBook($id)
    {
        return $this->bookRepository->deleteBook($id);
    }
}
