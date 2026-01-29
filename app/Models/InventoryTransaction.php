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
        'type_id',
        'code',
        'note',
        'created_by',
        'created_at',
    ];
    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }
    public function inventoryType()
    {
        return $this->belongsTo(InventoryType::class);
    }
}
