<?php

namespace App\Repositories;

use App\Core\BasicRepository;
use App\Models\Review;

class ReviewRepository extends BasicRepository
{
    public function __construct(Review $ReviewModel)
    {
        parent::__construct($ReviewModel);
    }

    public function search($params = [])
    {
        $query = $this->model->newQuery();

        return $this->paging($query);
    }
}