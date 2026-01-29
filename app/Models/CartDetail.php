<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'cart_id',
        'branch_product_id',
        'quantity',
    ];
    public function cart()
    {
        return $this->belongsTo(Cart::class);
    }
    public function branchProduct()
    {
        return $this->belongsTo(BranchProduct::class);
    }
}
