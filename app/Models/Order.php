<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
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
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }
    public function coupon()
    {
        return $this->belongsTo(Coupon::class);
    }
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
    public function shipping()
    {
        return $this->hasOne(Shipping::class);
    }
    public function payment()
    {
        return $this->hasOne(Payment::class);
    }
    public function couponUsages()
    {
        return $this->hasMany(CouponUsage::class);
    }
}
