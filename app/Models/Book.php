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
}
