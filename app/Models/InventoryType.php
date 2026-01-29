<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventoryType extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'code',
        'name',
    ];
    public function inventoryTransactions()
    {
        return $this->hasMany(InventoryTransaction::class);
    }
}
