<?php

namespace App\Repositories;

use App\Core\BasicRepository;
use App\Models\User;

class UserRepository extends BasicRepository
{
    public function __construct(User $UserModel)
    {
        parent::__construct($UserModel);
    }

    public function search($params = [])
    {
        $query = $this->model->newQuery();

        $keyword = $params['keyword'] ?? request()->get('keyword');
        if (!empty($keyword)) {
            $query->where(function ($q) use ($keyword) {
                $q->where('name', 'like', "%{$keyword}%");
                $q->orWhere('email', 'like', "%{$keyword}%");
            });
        }

        return $this->paging($query);
    }
}