<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'username',
        'full_name',
        'email',
        'password',
        'role',
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

    public function borrowings()
    {
        return $this->hasMany(Borrowing::class);
    }

    public function readOnlines()
    {
        return $this->hasMany(ReadOnline::class);
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    public function userReadings()
    {
        return $this->hasMany(UserReading::class);
    }

    public function ratingBooks()
    {
        return $this->hasMany(RatingBook::class);
    }

    public function bookmarks()
    {
        return $this->belongsToMany(Book::class, 'bookmarks')->withTimestamps();
    }
}
