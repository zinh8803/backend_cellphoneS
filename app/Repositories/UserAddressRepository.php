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
    public function unsetDefaultForUser($userId)
    {
        $this->model->where('user_id', $userId)->where('is_default', true)->update(['is_default' => false]);
    }
}
