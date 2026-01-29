<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventoryTransactionItem extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'transaction_id',
        'branch_product_id',
        'quantity',
        'unit_price',
    ];
    public function inventoryTransaction()
    {
        return $this->belongsTo(InventoryTransaction::class, 'transaction_id');
    }
    public function branchProduct()
    {
        return $this->belongsTo(BranchProduct::class);
    }
}
