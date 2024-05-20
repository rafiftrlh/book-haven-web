<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Permission extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['approved_by', 'borrowing_id', 'permission_date', 'status'];

    public function user()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function borrowing()
    {
        return $this->belongsTo(Borrowing::class);
    }

}
