<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAddress extends Model
{
    use HasFactory;


    protected $fillable = [
        'id',
        'user_id',
        'city_id',
        'ward_id',
        'detail',
        'receiver_name',
        'phone',
        'is_default',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
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
