<?php
namespace App\Repositories\Contracts;

interface BookBorrowedRepositoryInterface
{
    public function getUserBorrowedBooks($user_id,$perPage);
    public function borrowBook(array $data);
    public function returnBorrowBook(array $data);
    public function payFinesReturnBorrowBook(array $data);      
}