<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'code',
        'discount_type',
        'discount_value',
        'min_order_value',
        'max_discount',
        'max_total_usage',
        'max_per_user',
        'allow_with_sale',
        'start_at',
        'end_at',
        'status',
    ];
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
