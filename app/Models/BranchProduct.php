<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BranchProduct extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'branch_id',
        'product_variant_id',
        'price',
        'stock',
        'status',
        'created_at',
    ];
    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }
    public function productVariant()
    {
        return $this->belongsTo(ProductVariant::class);
    }
    public function cartDetails()
    {
        return $this->hasMany(CartDetail::class);
    }
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
    public function flashSales()
    {
        return $this->hasMany(FlashSale::class);
    }
}
