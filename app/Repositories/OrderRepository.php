<?php

namespace App\Repositories;

use App\Core\BasicRepository;
use App\Models\Order;

class OrderRepository extends BasicRepository
{
    public function __construct(Order $OrderModel)
    {
        parent::__construct($OrderModel);
    }

    public function search($params = [])
    {
        $query = $this->model->newQuery();

        return $this->paging($query);
    }
}