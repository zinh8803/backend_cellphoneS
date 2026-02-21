<?php

namespace App\Services;

use App\Repositories\OrderRepository;

class OrderService
{
    protected OrderRepository $OrderRepository;

    public function __construct(OrderRepository $OrderRepository)
    {
        $this->OrderRepository = $OrderRepository;
    }

    public function all($params = [])
    {
        return $this->OrderRepository->all($params);
    }

    public function search($params = [])
    {
        return $this->OrderRepository->search($params);
    }

    public function show($id)
    {
        return $this->OrderRepository->show($id);
    }

    public function store(array $data)
    {
        return $this->OrderRepository->store($data);
    }

    public function update($id, array $data = [])
    {
        return $this->OrderRepository->update($id, $data);
    }

    public function destroy($id)
    {
        return $this->OrderRepository->destroy($id);
    }
}