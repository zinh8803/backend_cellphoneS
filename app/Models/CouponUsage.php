<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CouponUsage extends Model
{
    use HasFactory;

    protected $table = 'coupon_usage';

    public $timestamps = false;

    protected $fillable = [
        'id',
        'coupon_id',
        'user_id',
        'order_id',
        'used_at',
    ];
}
