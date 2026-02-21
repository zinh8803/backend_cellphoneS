<?php

namespace App\Services;

use App\Repositories\ProductTagRepository;

class ProductTagService
{
    protected ProductTagRepository $ProductTagRepository;

    public function __construct(ProductTagRepository $ProductTagRepository)
    {
        $this->ProductTagRepository = $ProductTagRepository;
    }

    public function all($params = [])
    {
        return $this->ProductTagRepository->all($params);
    }

    public function search($params = [])
    {
        return $this->ProductTagRepository->search($params);
    }

    public function show($id)
    {
        return $this->ProductTagRepository->show($id);
    }

    public function store(array $data)
    {
        return $this->ProductTagRepository->store($data);
    }

    public function update($id, array $data = [])
    {
        return $this->ProductTagRepository->update($id, $data);
    }

    public function destroy($id)
    {
        return $this->ProductTagRepository->destroy($id);
    }
}