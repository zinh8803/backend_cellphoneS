<?php

namespace App\Repositories;

use App\Core\BasicRepository;
use App\Models\UserAddress;

class UserAddressRepository extends BasicRepository
{
    public function __construct(UserAddress $UserAddressModel)
    {
        parent::__construct($UserAddressModel);
    }

    public function search($params = [])
    {
        $query = $this->model->newQuery();

        return $this->paging($query);
    }
}