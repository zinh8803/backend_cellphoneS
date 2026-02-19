<?php

namespace App\Services;

use App\Repositories\ShippingRepository;

class ShippingService
{
    protected ShippingRepository $ShippingRepository;

    public function __construct(ShippingRepository $ShippingRepository)
    {
        $this->ShippingRepository = $ShippingRepository;
    }

    public function all($params = [])
    {
        return $this->ShippingRepository->all($params);
    }

    public function search($params = [])
    {
        return $this->ShippingRepository->search($params);
    }

    public function show($id)
    {
        return $this->ShippingRepository->show($id);
    }

    public function store(array $data)
    {
        return $this->ShippingRepository->store($data);
    }

    public function update($id, array $data = [])
    {
        return $this->ShippingRepository->update($id, $data);
    }

    public function destroy($id)
    {
        return $this->ShippingRepository->destroy($id);
    }
}