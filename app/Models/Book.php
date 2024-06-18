<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Book extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'book_code',
        'title_book',
        'cover',
        'synopsis',
        'language',
        'stock'
    ];

    public function borrowings()
    {
        return $this->hasMany(Borrowing::class);
    }

    public function authors()
    {
        return $this->belongsToMany(Author::class, 'book_authors');
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'book_categories');
    }

    public function conditionBooks()
    {
        return $this->hasMany(ConditionBook::class);
    }

    public function readOnlines()
    {
        return $this->hasMany(ReadOnline::class);
    }

    public function userReadings()
    {
        return $this->hasMany(UserReading::class);
    }

    public function reviews()
    {
        return $this->hasMany(RatingBook::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function bookmarkedByUsers()
    {
        return $this->belongsToMany(User::class, 'bookmarks')->withTimestamps();
    }
}
