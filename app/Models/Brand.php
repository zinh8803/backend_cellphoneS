<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Brand extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'name',
        'slug',
    ];
    public function products()
    {
        return $this->hasMany(Product::class);
    }
    public function getRouteKeyName()
    {
        return 'slug';
    }
    protected static function booted()
    {
        static::creating(function ($brand) {
            $brand->slug = Str::slug($brand->name);
        });
    }
}
