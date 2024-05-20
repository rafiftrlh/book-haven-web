<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ReadOnline extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['user_id', 'book_id', 'request_date', 'approval_status', 'read_end_date'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function book()
    {
        return $this->belongsTo(Book::class);
    }
}
