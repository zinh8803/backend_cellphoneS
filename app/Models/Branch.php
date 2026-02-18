<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'name',
        'detail',
        'city_id',
        'ward_id',
    ];

    public function employees()
    {
        return $this->hasMany(Employee::class);
    }
    public function inventoryTransactions()
    {
        return $this->hasMany(InventoryTransaction::class);
    }
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function ward()
    {
        return $this->belongsTo(Ward::class);
    }
}
