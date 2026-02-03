<?php

namespace App\Repositories;

use App\Core\BasicRepository;
use App\Models\Cart;

class CartRepository extends BasicRepository
{
    public function __construct(Cart $CartModel)
    {
        parent::__construct($CartModel);
    }

    public function search($params = [])
    {
        $query = $this->model->newQuery();

        return $this->paging($query);
    }
}