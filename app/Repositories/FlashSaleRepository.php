<?php

namespace App\Repositories;

use App\Core\BasicRepository;
use App\Models\FlashSale;

class FlashSaleRepository extends BasicRepository
{
    public function __construct(FlashSale $FlashSaleModel)
    {
        parent::__construct($FlashSaleModel);
    }

    public function search($params = [])
    {
        $query = $this->model->newQuery();

        return $this->paging($query);
    }
}