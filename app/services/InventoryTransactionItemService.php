<?php

namespace App\Services;

use App\Repositories\InventoryTransactionItemRepository;

class InventoryTransactionItemService
{
    protected InventoryTransactionItemRepository $InventoryTransactionItemRepository;

    public function __construct(InventoryTransactionItemRepository $InventoryTransactionItemRepository)
    {
        $this->InventoryTransactionItemRepository = $InventoryTransactionItemRepository;
    }

    public function all($params = [])
    {
        return $this->InventoryTransactionItemRepository->all($params);
    }

    public function search($params = [])
    {
        return $this->InventoryTransactionItemRepository->search($params);
    }

    public function show($id)
    {
        return $this->InventoryTransactionItemRepository->show($id);
    }

    public function store(array $data)
    {
        return $this->InventoryTransactionItemRepository->store($data);
    }

    public function update($id, array $data = [])
    {
        return $this->InventoryTransactionItemRepository->update($id, $data);
    }

    public function destroy($id)
    {
        return $this->InventoryTransactionItemRepository->destroy($id);
    }
}