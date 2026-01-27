<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $table = 'orders';

    public $timestamps = false;

    protected $fillable = [
        'id',
        'user_id',
        'branch_id',
        'total_amount',
        'status',
        'coupon_id',
        'discount_amount',
        'created_at',
    ];
}
