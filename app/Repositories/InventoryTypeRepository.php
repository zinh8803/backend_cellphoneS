<?php

namespace App\Repositories;

use App\Core\BasicRepository;
use App\Models\InventoryType;

class InventoryTypeRepository extends BasicRepository
{
    public function __construct(InventoryType $InventoryTypeModel)
    {
        parent::__construct($InventoryTypeModel);
    }

    public function search($params = [])
    {
        $query = $this->model->newQuery();

        $keyword = $params['keyword'] ?? request()->get('keyword');
        if (!empty($keyword)) {
            $query->where(function ($q) use ($keyword) {
                $q->where('code', 'like', "%{$keyword}%");
                $q->orWhere('name', 'like', "%{$keyword}%");
            });
        }

        return $this->paging($query);
    }
}