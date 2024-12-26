<?php

namespace App\Services;

use App\Repositories\Contracts\BookBorrowedRepositoryInterface;

class BookBorrowedService
{
    protected $bookBorrowedRepository;

    public function __construct(BookBorrowedRepositoryInterface $bookBorrowedRepository)
    {
        $this->bookBorrowedRepository = $bookBorrowedRepository;
    }

    public function getUserBorrowedBooks($user_id,$perPage)
    {
        return $this->bookBorrowedRepository->getUserBorrowedBooks($user_id,$perPage);
    }

    public function borrowBook(array $data)
    {
        return $this->bookBorrowedRepository->borrowBook($data);
    }

    public function returnBorrowBook(array $data)
    {
        return $this->bookBorrowedRepository->returnBorrowBook($data);
    }

    public function payFinesReturnBorrowBook(array $data)
    {
        return $this->bookBorrowedRepository->payFinesReturnBorrowBook($data);
    }
}
