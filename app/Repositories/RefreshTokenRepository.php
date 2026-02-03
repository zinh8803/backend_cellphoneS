<?php

namespace App\Repositories;

use App\Core\BasicRepository;
use App\Models\RefreshToken;

class RefreshTokenRepository extends BasicRepository
{
    public function __construct(RefreshToken $RefreshTokenModel)
    {
        parent::__construct($RefreshTokenModel);
    }

    public function search($params = [])
    {
        $query = $this->model->newQuery();

        return $this->paging($query);
    }
}