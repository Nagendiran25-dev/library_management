<?php
namespace App\Repositories\Contracts;

interface BookRepositoryInterface
{
    public function getBooksByStatus($status,$perPage);
    public function getBookById($id);
    public function createBook(array $data);
    public function updateBook($id, array $data);
    public function deleteBook($id);
    
}