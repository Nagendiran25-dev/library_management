<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Book extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'author',
        'description',
        'published_date',
        'status'
    ];

    // Book Model
    public function borrowedBooks()
    {
        return $this->hasMany(BorrowedBook::class);
    }
    /**
     * Get the updated_at attribute in m/d/Y H:i format.
     *
     * @param  mixed  $date
     * @return string
     */
    public function getPublishedDateAttribute($date)
    {
        return $this->formatDate($date);
    }
    /**
     * Get the updated_at attribute in m/d/Y H:i format.
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
