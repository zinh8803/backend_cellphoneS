<?php

namespace App\Services;

use App\Repositories\UserRepository;

class UserService
{
    protected UserRepository $UserRepository;

    public function __construct(UserRepository $UserRepository)
    {
        $this->UserRepository = $UserRepository;
    }

    public function all($params = [])
    {
        return $this->UserRepository->all($params);
    }

    public function search($params = [])
    {
        return $this->UserRepository->search($params);
    }

    public function show($id)
    {
        return $this->UserRepository->show($id);
    }

    public function store(array $data)
    {
        return $this->UserRepository->store($data);
    }

    public function update($id, array $data = [])
    {
        return $this->UserRepository->update($id, $data);
    }

    public function destroy($id)
    {
        return $this->UserRepository->destroy($id);
    }
}