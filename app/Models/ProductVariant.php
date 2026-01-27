<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductVariant extends Model
{
    use HasFactory;

    protected $table = 'product_variant';

    public $timestamps = false;

    protected $fillable = [
        'id',
        'product_id',
        'color_id',
        'storage_id',
        'sku',
    ];
}
