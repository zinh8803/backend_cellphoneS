<?php

namespace App\Repositories;

use App\Core\BasicRepository;
use App\Models\Role;

class RoleRepository extends BasicRepository
{
    public function __construct(Role $RoleModel)
    {
        parent::__construct($RoleModel);
    }

    public function search($params = [])
    {
        $query = $this->model->newQuery();

        $keyword = $params['keyword'] ?? request()->get('keyword');
        if (!empty($keyword)) {
            $query->where(function ($q) use ($keyword) {
                $q->where('name', 'like', "%{$keyword}%");
            });
        }

        return $this->paging($query);
    }
}