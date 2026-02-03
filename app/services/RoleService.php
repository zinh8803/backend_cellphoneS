<?php

namespace App\Services;

use App\Repositories\RoleRepository;

class RoleService
{
    protected RoleRepository $RoleRepository;

    public function __construct(RoleRepository $RoleRepository)
    {
        $this->RoleRepository = $RoleRepository;
    }

    public function all($params = [])
    {
        return $this->RoleRepository->all($params);
    }

    public function search($params = [])
    {
        return $this->RoleRepository->search($params);
    }

    public function show($id)
    {
        return $this->RoleRepository->show($id);
    }

    public function store(array $data)
    {
        return $this->RoleRepository->store($data);
    }

    public function update($id, array $data = [])
    {
        return $this->RoleRepository->update($id, $data);
    }

    public function destroy($id)
    {
        return $this->RoleRepository->destroy($id);
    }
}