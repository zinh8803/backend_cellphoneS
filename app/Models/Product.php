<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

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
    public function getRouteKeyName()
    {
        return 'slug';
    }
    protected static function booted()
    {
        static::creating(function ($product) {
            $product->slug = Str::slug($product->name);
        });
    }
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

    public function productAttributeValues()
    {
        return $this->hasMany(ProductAttributeValue::class, 'product_id');
    }

    public function attributes()
    {
        return $this->hasManyThrough(
            Attribute::class,
            ProductAttributeValue::class,
            'product_id',
            'id',
            'id',
            'attribute_id'
        );
    }
}
