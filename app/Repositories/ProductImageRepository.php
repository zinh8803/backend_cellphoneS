<?php

namespace App\Repositories;

use App\Core\BasicRepository;
use App\Models\ProductImage;

class ProductImageRepository extends BasicRepository
{
    public function __construct(ProductImage $ProductImageModel)
    {
        parent::__construct($ProductImageModel);
    }

    public function search($params = [])
    {
        $query = $this->model->newQuery();

        return $this->paging($query);
    }
}