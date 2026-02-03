<?php

namespace App\Repositories;

use App\Core\BasicRepository;
use App\Models\Coupon;

class CouponRepository extends BasicRepository
{
    public function __construct(Coupon $CouponModel)
    {
        parent::__construct($CouponModel);
    }

    public function search($params = [])
    {
        $query = $this->model->newQuery();

        $keyword = $params['keyword'] ?? request()->get('keyword');
        if (!empty($keyword)) {
            $query->where(function ($q) use ($keyword) {
                $q->where('code', 'like', "%{$keyword}%");
            });
        }

        return $this->paging($query);
    }
}