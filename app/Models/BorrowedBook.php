<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
class BorrowedBook extends Model
{
    use HasFactory;

    // The table associated with the model.
    protected $table = 'borrowed_books';

    // The primary key associated with the table.
    protected $primaryKey = 'id';

    // The attributes that are mass assignable.
    protected $fillable = [
        'user_id',
        'book_id',
        'borrowed_date',
        'due_date',
        'return_date',
        'fine_amount',
        'status'
    ];

    /**
     * Get the user that borrowed the book.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the book that is borrowed.
     */
    public function book()
    {
        return $this->belongsTo(Book::class);
    }
    /* Get the updated_at attribute in m/d/Y H:i format.
    *
    * @param  mixed  $date
    * @return string
    */
   public function getUpdatedAtAttribute($date)
   {
       return $this->formatDate($date);
   }
   /**
    * Format the given date in m/d/Y H:i format.
    *
    * @param  mixed  $date
    * @return string
    */
    /**
    * Get the created_at attribute in m/d/Y H:i format.
    *
    * @param  mixed  $date
    * @return string
    */
   public function getCreatedAtAttribute($date)
   {
       return $this->formatDate($date);
   }
   private function formatDate($date)
   {
       // Attempt to parse the date and return the formatted value, or a fallback default if invalid
       return $date ? Carbon::parse($date)->format('m-d-Y H:i') : ''; // Default fallback date
   }
}
