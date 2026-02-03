<?php

namespace App\Services;

use App\Repositories\CartRepository;

class CartService
{
    protected CartRepository $CartRepository;

    public function __construct(CartRepository $CartRepository)
    {
        $this->CartRepository = $CartRepository;
    }

    public function all($params = [])
    {
        return $this->CartRepository->all($params);
    }

    public function search($params = [])
    {
        return $this->CartRepository->search($params);
    }

    public function show($id)
    {
        return $this->CartRepository->show($id);
    }

    public function store(array $data)
    {
        return $this->CartRepository->store($data);
    }

    public function update($id, array $data = [])
    {
        return $this->CartRepository->update($id, $data);
    }

    public function destroy($id)
    {
        return $this->CartRepository->destroy($id);
    }
}