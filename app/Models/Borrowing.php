<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Borrowing extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'book_id', 'borrow_date', 'return_date', 'due_date', 'status'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    public function permissions()
    {
        return $this->hasMany(Permission::class);
    }

    public function conditionBooks()
    {
        return $this->hasMany(ConditionBook::class);
    }

    public function fines()
    {
        return $this->hasMany(Fine::class);
    }


}
