<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'order_id',
        'branch_product_id',
        'quantity',
        'price_snapshot',
    ];
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
    public function branchProduct()
    {
        return $this->belongsTo(BranchProduct::class);
    }
}
