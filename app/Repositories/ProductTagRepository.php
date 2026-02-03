<?php

namespace App\Repositories;

use App\Core\BasicRepository;
use App\Models\ProductTag;

class ProductTagRepository extends BasicRepository
{
    public function __construct(ProductTag $ProductTagModel)
    {
        parent::__construct($ProductTagModel);
    }

    public function search($params = [])
    {
        $query = $this->model->newQuery();

        return $this->paging($query);
    }
}