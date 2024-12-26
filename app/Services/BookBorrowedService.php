<?php

namespace App\Services;

use App\Repositories\Contracts\BookBorrowedRepositoryInterface;
use Carbon\Carbon;
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
        $bookReturnDay = env('BOOK_RETURN_DAY', 14);
        // Get the current date and time in 'Y-m-d H:i' format
        $data['borrowed_date'] = now()->format('Y-m-d H:i');
        // Calculate the due date by adding the return period (BOOK_RETURN_DAY) to the current date
        $data['due_date'] = now()->addDays($bookReturnDay)->format('Y-m-d H:i');
        return $this->bookBorrowedRepository->borrowBook($data);
    }

    public function returnBorrowBook(array $data)
    {
        //Check Fine Amount
        $getBorrowedDetails=$this->bookBorrowedRepository->getBorrowedDetails($data['borrowed_id']);
        $dueDate = Carbon::parse($getBorrowedDetails['due_date']);
        $currentDate = Carbon::now();
        
        // Calculate the difference in days (dueDate and currentDate)
        $diff = $dueDate->diffInDays($currentDate, false); 
        
        $bookfine_perday = env('FINE_AMT_PER_DAY', 10);
        
        // If the book is overdue, calculate the fine
        if ($diff > 0) {
            $fineAmount = $diff * $bookfine_perday;
            if(isset($data['fine_amount']))
            {
                if($fineAmount==$data['fine_amount'])
                {
                    $data['return_date']= $currentDate->format('Y-m-d H:i');
                    $data['status']=0;
                    $this->bookBorrowedRepository->returnBorrowBook($data);
                    return [
                        'status' => 'returned',
                        'message' => 'Book returned successfully with fine.',
                    ]; 
                }
            }
            //fineAmount if needed
            return[
                'status' => 'overdue',
                'overdue_days'=>$diff,
                'per_day_fine_amount'=>$bookfine_perday,
                'fine_amount' => $fineAmount,
            ];
        } else {
            // If no fine, return the book without a fine
            $data['return_date']= $currentDate->format('Y-m-d H:i');
            $data['status']=0;
            $data['fine_amount']=0;
            $this->bookBorrowedRepository->returnBorrowBook($data);
            return [
                'status' => 'returned',
                'message' => 'Book returned successfully without fine.',
            ];
        }
    }

    public function getAllBorrwedDetails(array $data)
    {
        return $this->bookBorrowedRepository->getAllBorrwedDetails($data);
    }
}
