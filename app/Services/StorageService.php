<?php

namespace App\Services;

use App\Repositories\StorageRepository;

class StorageService
{
    protected StorageRepository $StorageRepository;

    public function __construct(StorageRepository $StorageRepository)
    {
        $this->StorageRepository = $StorageRepository;
    }

    public function all($params = [])
    {
        return $this->StorageRepository->all($params);
    }

    public function search($params = [])
    {
        return $this->StorageRepository->search($params);
    }

    public function show($id)
    {
        return $this->StorageRepository->show($id);
    }

    public function store(array $data)
    {
        return $this->StorageRepository->store($data);
    }

    public function update($id, array $data = [])
    {
        return $this->StorageRepository->update($id, $data);
    }

    public function destroy($id)
    {
        return $this->StorageRepository->destroy($id);
    }
}