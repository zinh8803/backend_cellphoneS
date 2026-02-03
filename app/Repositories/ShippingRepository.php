<?php

namespace App\Repositories;

use App\Core\BasicRepository;
use App\Models\Shipping;

class ShippingRepository extends BasicRepository
{
    public function __construct(Shipping $ShippingModel)
    {
        parent::__construct($ShippingModel);
    }

    public function search($params = [])
    {
        $query = $this->model->newQuery();

        return $this->paging($query);
    }
}