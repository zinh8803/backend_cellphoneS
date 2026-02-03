<?php

namespace App\Repositories;

use App\Core\BasicRepository;
use App\Models\CouponUsage;

class CouponUsageRepository extends BasicRepository
{
    public function __construct(CouponUsage $CouponUsageModel)
    {
        parent::__construct($CouponUsageModel);
    }

    public function search($params = [])
    {
        $query = $this->model->newQuery();

        return $this->paging($query);
    }
}