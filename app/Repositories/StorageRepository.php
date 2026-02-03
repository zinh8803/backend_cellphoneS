<?php

namespace App\Repositories;

use App\Core\BasicRepository;
use App\Models\Storage;

class StorageRepository extends BasicRepository
{
    public function __construct(Storage $StorageModel)
    {
        parent::__construct($StorageModel);
    }

    public function search($params = [])
    {
        $query = $this->model->newQuery();

        return $this->paging($query);
    }
}