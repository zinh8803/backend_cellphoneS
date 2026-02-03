<?php

namespace App\Repositories;

use App\Core\BasicRepository;
use App\Models\BranchProduct;

class BranchProductRepository extends BasicRepository
{
    public function __construct(BranchProduct $BranchProductModel)
    {
        parent::__construct($BranchProductModel);
    }

    public function search($params = [])
    {
        $query = $this->model->newQuery();

        return $this->paging($query);
    }
}