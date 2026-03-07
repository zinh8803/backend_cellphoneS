<?php

namespace App\Repositories;

use App\Core\BasicRepository;
use App\Models\Product;

class ProductRepository extends BasicRepository
{
    public function __construct(Product $product)
    {
        parent::__construct($product);
    }

    public function all($params = [])
    {
        $query = $this->model->newQuery()->with([
            'brand',
            'category',
            'productImages.image',
            'productTags.tag',
            'productAttributeValues.attribute'
        ]);

        return $this->paging($query);
    }

    public function search($params = [])
    {
        $query = $this->model->newQuery()->with([
            'brand',
            'category',
            'productImages.image',
            'productTags.tag',
            'productAttributeValues.attribute'
        ]);

        $keyword = $params['keyword'] ?? request()->get('keyword');
        if (!empty($keyword)) {
            $query->where(function ($q) use ($keyword) {
                $q->where('name', 'like', "%{$keyword}%")
                    ->orWhere('slug', 'like', "%{$keyword}%");
            });
        }

        $brandId = $params['brand_id'] ?? request()->get('brand_id');
        if (!empty($brandId)) {
            $query->where('brand_id', $brandId);
        }

        $categoryId = $params['category_id'] ?? request()->get('category_id');
        if (!empty($categoryId)) {
            $query->where('category_id', $categoryId);
        }

        $tagId = $params['tag_id'] ?? request()->get('tag_id');
        if (!empty($tagId)) {
            $query->whereHas('productTags', function ($q) use ($tagId) {
                $q->where('tag_id', $tagId);
            });
        }

        return $this->paging($query);
    }

    public function show($id)
    {
        return $this->model->newQuery()->with([
            'brand',
            'category',
            'productImages.image',
            'productTags.tag',
            'productAttributeValues.attribute',
        ])->find($id);
    }
}
