<?php

namespace App\Repositories;

use App\Core\BasicRepository;
use App\Models\Brand;

class BrandRepository extends BasicRepository
{
    public function __construct(Brand $brand)
    {
        parent::__construct($brand);
    }

    public function search($params = [])
    {
        $query = $this->model->newQuery();

        $keyword = $params['keyword'] ?? request()->get('keyword');
        if (!empty($keyword)) {
            $query->where(function ($q) use ($keyword) {
                $q->where('name', 'like', "%{$keyword}%")
                    ->orWhere('slug', 'like', "%{$keyword}%");
            });
        }

        return $this->paging($query);
    }
}
