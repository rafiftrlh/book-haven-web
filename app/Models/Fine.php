<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Fine extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['borrowing_id', 'condition', 'type', 'price'];

    public function borrowing()
    {
        return $this->belongsTo(Borrowing::class);
    }
}
