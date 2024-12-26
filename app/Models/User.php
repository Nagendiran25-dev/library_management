<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Carbon\Carbon;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'mobile_number',
        'role'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
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
    private function formatDate($date)
    {
        // Attempt to parse the date and return the formatted value, or a fallback default if invalid
        return $date ? Carbon::parse($date)->format('m/d/Y H:i') : ''; // Default fallback date
    }
}
