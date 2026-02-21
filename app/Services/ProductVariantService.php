<?php

namespace App\Services;

use App\Repositories\ProductVariantRepository;

class ProductVariantService
{
    protected ProductVariantRepository $ProductVariantRepository;

    public function __construct(ProductVariantRepository $ProductVariantRepository)
    {
        $this->ProductVariantRepository = $ProductVariantRepository;
    }

    public function all($params = [])
    {
        return $this->ProductVariantRepository->all($params);
    }

    public function search($params = [])
    {
        return $this->ProductVariantRepository->search($params);
    }

    public function show($id)
    {
        return $this->ProductVariantRepository->show($id);
    }

    public function store(array $data)
    {
        return $this->ProductVariantRepository->store($data);
    }

    public function update($id, array $data = [])
    {
        return $this->ProductVariantRepository->update($id, $data);
    }

    public function destroy($id)
    {
        return $this->ProductVariantRepository->destroy($id);
    }
}