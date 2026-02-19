<?php

namespace App\Services;

use App\Repositories\UserAddressRepository;

class UserAddressService
{
    protected UserAddressRepository $UserAddressRepository;

    public function __construct(UserAddressRepository $UserAddressRepository)
    {
        $this->UserAddressRepository = $UserAddressRepository;
    }

    public function all($params = [])
    {
        return $this->UserAddressRepository->all($params);
    }

    public function search($params = [])
    {
        return $this->UserAddressRepository->search($params);
    }

    public function show($id)
    {
        return $this->UserAddressRepository->show($id);
    }

    public function store(array $data)
    {
        return $this->UserAddressRepository->store($data);
    }

    public function update($id, array $data = [])
    {
        return $this->UserAddressRepository->update($id, $data);
    }

    public function destroy($id)
    {
        return $this->UserAddressRepository->destroy($id);
    }
}