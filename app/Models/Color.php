<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Color extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'name',
        'code',
    ];
    public function productVariants()
    {
        return $this->hasMany(ProductVariant::class);
    }
}
