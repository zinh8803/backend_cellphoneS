<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $table = 'order_item';

    public $timestamps = false;

    protected $fillable = [
        'id',
        'order_id',
        'branch_product_id',
        'quantity',
        'price_snapshot',
    ];
}
