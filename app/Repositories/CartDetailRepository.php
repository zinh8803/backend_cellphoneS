<?php

namespace App\Repositories;

use App\Core\BasicRepository;
use App\Models\CartDetail;

class CartDetailRepository extends BasicRepository
{
    public function __construct(CartDetail $CartDetailModel)
    {
        parent::__construct($CartDetailModel);
    }

    public function search($params = [])
    {
        $query = $this->model->newQuery();

        return $this->paging($query);
    }
}