<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Borrowing extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'book_id',
        'borrow_date',
        'return_date',
        'due_date',
        'status',
        'approved_by',
        'permission_date'
    ];
    public function users()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function books()
    {
        return $this->belongsTo(Book::class, 'book_id');
    }

    public function conditionBooks()
    {
        return $this->hasMany(ConditionBook::class);
    }

    public function fines()
    {
        return $this->hasOne(Fine::class);
    }


}
