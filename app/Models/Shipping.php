<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shipping extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'order_id',
        'address',
        'status',
        'shipped_at',
        'delivered_at',
    ];
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
