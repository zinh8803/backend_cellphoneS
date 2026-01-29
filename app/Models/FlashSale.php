<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FlashSale extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'branch_product_id',
        'discount_type',
        'discount_value',
        'start_at',
        'end_at',
        'is_stackable',
        'status',
    ];
    public function branchProduct()
    {
        return $this->belongsTo(BranchProduct::class);
    }
}
