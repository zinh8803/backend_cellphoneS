<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ward extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'city_id',
        'code',
        'name',
        'district',
    ];
    public function city()
    {
        return $this->belongsTo(City::class);
    }
}
