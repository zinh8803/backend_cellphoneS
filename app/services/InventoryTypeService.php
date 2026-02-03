<?php

namespace App\Services;

use App\Repositories\InventoryTypeRepository;

class InventoryTypeService
{
    protected InventoryTypeRepository $InventoryTypeRepository;

    public function __construct(InventoryTypeRepository $InventoryTypeRepository)
    {
        $this->InventoryTypeRepository = $InventoryTypeRepository;
    }

    public function all($params = [])
    {
        return $this->InventoryTypeRepository->all($params);
    }

    public function search($params = [])
    {
        return $this->InventoryTypeRepository->search($params);
    }

    public function show($id)
    {
        return $this->InventoryTypeRepository->show($id);
    }

    public function store(array $data)
    {
        return $this->InventoryTypeRepository->store($data);
    }

    public function update($id, array $data = [])
    {
        return $this->InventoryTypeRepository->update($id, $data);
    }

    public function destroy($id)
    {
        return $this->InventoryTypeRepository->destroy($id);
    }
}