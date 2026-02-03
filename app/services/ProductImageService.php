<?php

namespace App\Services;

use App\Repositories\ProductImageRepository;

class ProductImageService
{
    protected ProductImageRepository $ProductImageRepository;

    public function __construct(ProductImageRepository $ProductImageRepository)
    {
        $this->ProductImageRepository = $ProductImageRepository;
    }

    public function all($params = [])
    {
        return $this->ProductImageRepository->all($params);
    }

    public function search($params = [])
    {
        return $this->ProductImageRepository->search($params);
    }

    public function show($id)
    {
        return $this->ProductImageRepository->show($id);
    }

    public function store(array $data)
    {
        return $this->ProductImageRepository->store($data);
    }

    public function update($id, array $data = [])
    {
        return $this->ProductImageRepository->update($id, $data);
    }

    public function destroy($id)
    {
        return $this->ProductImageRepository->destroy($id);
    }
}