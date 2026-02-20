<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Category extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'name',
        'slug',
    ];
    public function getRouteKeyName()
    {
        return 'slug';
    }
    protected static function booted()
    {
        static::creating(function ($category) {
            $category->slug = Str::slug($category->name);
        });
    }
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
