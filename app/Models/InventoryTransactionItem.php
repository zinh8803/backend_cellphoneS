<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventoryTransactionItem extends Model
{
    use HasFactory;

    protected $table = 'inventory_transaction_item';

    public $timestamps = false;

    protected $fillable = [
        'id',
        'transaction_id',
        'branch_product_id',
        'quantity',
        'unit_price',
    ];
}
