<?php

namespace App\Services;

use App\Repositories\InventoryTransactionRepository;

class InventoryTransactionService
{
    protected InventoryTransactionRepository $InventoryTransactionRepository;

    public function __construct(InventoryTransactionRepository $InventoryTransactionRepository)
    {
        $this->InventoryTransactionRepository = $InventoryTransactionRepository;
    }

    public function all($params = [])
    {
        return $this->InventoryTransactionRepository->all($params);
    }

    public function search($params = [])
    {
        return $this->InventoryTransactionRepository->search($params);
    }

    public function show($id)
    {
        return $this->InventoryTransactionRepository->show($id);
    }

    public function store(array $data)
    {
        return $this->InventoryTransactionRepository->store($data);
    }

    public function update($id, array $data = [])
    {
        return $this->InventoryTransactionRepository->update($id, $data);
    }

    public function destroy($id)
    {
        return $this->InventoryTransactionRepository->destroy($id);
    }
}