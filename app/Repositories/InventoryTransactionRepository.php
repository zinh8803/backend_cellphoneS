<?php

namespace App\Repositories;

use App\Core\BasicRepository;
use App\Models\InventoryTransaction;

class InventoryTransactionRepository extends BasicRepository
{
    public function __construct(InventoryTransaction $InventoryTransactionModel)
    {
        parent::__construct($InventoryTransactionModel);
    }

    public function search($params = [])
    {
        $query = $this->model->newQuery();

        $keyword = $params['keyword'] ?? request()->get('keyword');
        if (!empty($keyword)) {
            $query->where(function ($q) use ($keyword) {
                $q->where('code', 'like', "%{$keyword}%");
            });
        }

        return $this->paging($query);
    }
}