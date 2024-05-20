<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ConditionBook extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['book_id', 'borrowing_id', 'condition'];

    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    public function borrowing()
    {
        return $this->belongsTo(Borrowing::class);
    }
}
