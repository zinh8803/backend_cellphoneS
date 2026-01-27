<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventoryTransaction extends Model
{
    use HasFactory;

    protected $table = 'inventory_transaction';

    public $timestamps = false;

    protected $fillable = [
        'id',
        'branch_id',
        'type_id',
        'code',
        'note',
        'created_by',
        'created_at',
    ];
}
