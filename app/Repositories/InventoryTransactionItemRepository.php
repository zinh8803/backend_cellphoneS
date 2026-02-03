<?php

namespace App\Repositories;

use App\Core\BasicRepository;
use App\Models\InventoryTransactionItem;

class InventoryTransactionItemRepository extends BasicRepository
{
    public function __construct(InventoryTransactionItem $InventoryTransactionItemModel)
    {
        parent::__construct($InventoryTransactionItemModel);
    }

    public function search($params = [])
    {
        $query = $this->model->newQuery();

        return $this->paging($query);
    }
}