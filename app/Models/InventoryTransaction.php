<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventoryTransaction extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'branch_id',
        'inventory_type_id',
        'code',
        'note',
    ];
    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }
    public function inventoryType()
    {
        return $this->belongsTo(InventoryType::class, 'inventory_type_id');
    }

    public function items()
    {
        return $this->hasMany(InventoryTransactionItem::class, 'inventory_transaction_id');
    }
}
