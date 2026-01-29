<?php

namespace App\Repositories;

use App\Core\BasicRepository;
use App\Models\User;

class AuthRepository extends BasicRepository
{
    protected $model;
    public function __construct(User $user)
    {
        $this->model = $user;
    }
    public function getModel($params = [])
    {
        return $this->model->get();
    }
    public function findByEmail(string $email)
    {
        return $this->model->where('email', $email)->first();
    }
    public function create(array $data)
    {
        return $this->model->create($data);
    }
}
