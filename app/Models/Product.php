<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'name',
        'slug',
        'description',
        'category_id',
        'brand_id',
    ];
    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function review()
    {
        return $this->hasMany(Review::class);
    }
    public function favorite()
    {
        return $this->hasMany(Favorite::class);
    }
    public function productVariants()
    {
        return $this->hasMany(ProductVariant::class);
    }
    public function productTags()
    {
        return $this->hasMany(ProductTag::class);
    }
    public function productImages()
    {
        return $this->hasMany(ProductImage::class)
            ->orderByDesc('is_primary')
            ->orderBy('id');
    }
}
