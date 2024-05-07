<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Book extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title_book',
        'cover',
        'language',
        'stock',
        'total_rating',
        'total_readers',
    ];

    public function authors()
    {
        return $this->belongsToMany(Author::class, 'book_authors');
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'book_categories');
    }

    public function readers()
    {
        return $this->belongsToMany(User::class, 'user_readings');
    }

    public function borrowers()
    {
        return $this->belongsToMany(User::class, 'borrowings');
    }

    public function reviewers()
    {
        return $this->belongsToMany(User::class, 'reviews');
    }

    public function favored()
    {
        return $this->belongsToMany(User::class, 'favorite_books');
    }
}
