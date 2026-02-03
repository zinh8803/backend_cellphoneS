<?php

namespace App\Repositories;

use App\Core\BasicRepository;
use App\Models\Favorite;

class FavoriteRepository extends BasicRepository
{
    public function __construct(Favorite $FavoriteModel)
    {
        parent::__construct($FavoriteModel);
    }

    public function search($params = [])
    {
        $query = $this->model->newQuery();

        return $this->paging($query);
    }
}