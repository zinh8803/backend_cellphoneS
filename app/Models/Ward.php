<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ward extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'district_id',
        'name',
    ];
    public function city()
    {
        return $this->belongsTo(City::class);
    }
}
