<?php

namespace App\Repositories;

use App\Core\BasicRepository;
use App\Models\City;

class CityRepository extends BasicRepository
{
    public function __construct(City $CityModel)
    {
        parent::__construct($CityModel);
    }

    public function search($params = [])
    {
        $query = $this->model->newQuery();

        $keyword = $params['keyword'] ?? request()->get('keyword');
        if (!empty($keyword)) {
            $query->where(function ($q) use ($keyword) {
                $q->where('name', 'like', "%{$keyword}%");
            });
        }

        return $this->paging($query);
    }
}