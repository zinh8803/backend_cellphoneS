<?php

namespace App\Repositories;

use App\Core\BasicRepository;
use App\Models\Color;

class ColorRepository extends BasicRepository
{
    public function __construct(Color $color)
    {
        parent::__construct($color);
    }

    public function search($params = [])
    {
        $query = $this->model->newQuery();

        $keyword = $params['keyword'] ?? request()->get('keyword');
        if (!empty($keyword)) {
            $query->where(function ($q) use ($keyword) {
                $q->where('name', 'like', "%{$keyword}%")
                    ->orWhere('code', 'like', "%{$keyword}%");
            });
        }

        return $this->paging($query);
    }
}
