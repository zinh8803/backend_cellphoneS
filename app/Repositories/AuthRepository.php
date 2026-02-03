<?php

namespace App\Repositories;

use App\Core\BasicRepository;
use App\Models\User;

class AuthRepository extends BasicRepository
{
    public function __construct(User $user)
    {
        parent::__construct($user);
    }

    public function all($params = [])
    {
        return parent::all($params);
    }

    public function search($params = [])
    {
        $query = $this->model->newQuery();

        $keyword = $params['keyword'] ?? request()->get('keyword');
        if (!empty($keyword)) {
            $query->where(function ($q) use ($keyword) {
                $q->where('name', 'like', "%{$keyword}%")
                    ->orWhere('email', 'like', "%{$keyword}%");
            });
        }

        $roleId = $params['role_id'] ?? request()->get('role_id');
        if (!empty($roleId)) {
            $query->where('role_id', $roleId);
        }

        return $this->paging($query);
    }

    public function show($id)
    {
        return parent::show($id);
    }



    public function store($data)
    {
        return parent::store($data);
    }

    public function update($model, $data = [])
    {
        return parent::update($model, $data);
    }

    public function destroy($id)
    {
        return parent::destroy($id);
    }

    public function getModel($params = [])
    {
        return $this->all($params);
    }
    public function findByEmail(string $email)
    {
        return $this->model->where('email', $email)->first();
    }
    public function create(array $data)
    {
        return $this->store($data);
    }
    public function getByEmail($email)
    {
        return $this->findByEmail($email);
    }
}
