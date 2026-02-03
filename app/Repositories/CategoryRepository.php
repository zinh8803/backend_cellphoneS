<?php

namespace App\Repositories;

use App\Core\BasicRepository;
use App\Models\Category;

class CategoryRepository extends BasicRepository
{
    public function __construct(Category $category)
    {
        parent::__construct($category);
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
