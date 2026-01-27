<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $table = 'review';

    public $timestamps = false;

    protected $fillable = [
        'id',
        'user_id',
        'product_id',
        'rating',
        'comment',
        'created_at',
    ];
}
