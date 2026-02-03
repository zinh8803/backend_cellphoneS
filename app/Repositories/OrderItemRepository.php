<?php

namespace App\Repositories;

use App\Core\BasicRepository;
use App\Models\OrderItem;

class OrderItemRepository extends BasicRepository
{
    public function __construct(OrderItem $OrderItemModel)
    {
        parent::__construct($OrderItemModel);
    }

    public function search($params = [])
    {
        $query = $this->model->newQuery();

        return $this->paging($query);
    }
}