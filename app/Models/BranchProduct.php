<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BranchProduct extends Model
{
    use HasFactory;

    protected $table = 'branch_product';

    public $timestamps = false;

    protected $fillable = [
        'id',
        'branch_id',
        'product_variant_id',
        'price',
        'stock',
        'status',
        'created_at',
    ];
}
