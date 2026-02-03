<?php

namespace App\Repositories;

use App\Core\BasicRepository;
use App\Models\ProductVariant;

class ProductVariantRepository extends BasicRepository
{
    public function __construct(ProductVariant $ProductVariantModel)
    {
        parent::__construct($ProductVariantModel);
    }

    public function search($params = [])
    {
        $query = $this->model->newQuery();

        return $this->paging($query);
    }
}