<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attribute extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'name',
    ];
    public function ProductAttributeValue()
    {
        return $this->hasMany(ProductAttributeValue::class);
    }
}
