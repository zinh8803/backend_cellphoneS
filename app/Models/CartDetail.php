<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartDetail extends Model
{
    use HasFactory;

    protected $table = 'cart_detail';

    public $timestamps = false;

    protected $fillable = [
        'id',
        'cart_id',
        'branch_product_id',
        'quantity',
    ];
}
