<?php

namespace App\Services;

use App\Repositories\OrderItemRepository;

class OrderItemService
{
    protected OrderItemRepository $OrderItemRepository;

    public function __construct(OrderItemRepository $OrderItemRepository)
    {
        $this->OrderItemRepository = $OrderItemRepository;
    }

    public function all($params = [])
    {
        return $this->OrderItemRepository->all($params);
    }

    public function search($params = [])
    {
        return $this->OrderItemRepository->search($params);
    }

    public function show($id)
    {
        return $this->OrderItemRepository->show($id);
    }

    public function store(array $data)
    {
        return $this->OrderItemRepository->store($data);
    }

    public function update($id, array $data = [])
    {
        return $this->OrderItemRepository->update($id, $data);
    }

    public function destroy($id)
    {
        return $this->OrderItemRepository->destroy($id);
    }
}