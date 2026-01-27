<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAddress extends Model
{
    use HasFactory;

    protected $table = 'user_address';

    public $timestamps = false;

    protected $fillable = [
        'id',
        'user_id',
        'city_id',
        'district_id',
        'ward_id',
        'detail',
        'receiver_name',
        'phone',
        'is_default',
        'created_at',
    ];
}
