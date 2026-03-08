<?php

namespace App\Repositories;

use App\Core\BasicRepository;
use App\Models\Attribute;

class AttributeRepository extends BasicRepository
{
    public function __construct(Attribute $attribute)
    {
        parent::__construct($attribute);
    }

    public function search($params = [])
    {
        $query = $this->model->newQuery();

        $keyword = $params['keyword'] ?? request()->get('keyword');
        if (!empty($keyword)) {
            $query->where('name', 'like', "%{$keyword}%");
        }

        return $this->paging($query);
    }
}
