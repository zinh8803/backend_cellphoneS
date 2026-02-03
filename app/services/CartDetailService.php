<?php

namespace App\Services;

use App\Repositories\CartDetailRepository;

class CartDetailService
{
    protected CartDetailRepository $CartDetailRepository;

    public function __construct(CartDetailRepository $CartDetailRepository)
    {
        $this->CartDetailRepository = $CartDetailRepository;
    }

    public function all($params = [])
    {
        return $this->CartDetailRepository->all($params);
    }

    public function search($params = [])
    {
        return $this->CartDetailRepository->search($params);
    }

    public function show($id)
    {
        return $this->CartDetailRepository->show($id);
    }

    public function store(array $data)
    {
        return $this->CartDetailRepository->store($data);
    }

    public function update($id, array $data = [])
    {
        return $this->CartDetailRepository->update($id, $data);
    }

    public function destroy($id)
    {
        return $this->CartDetailRepository->destroy($id);
    }
}