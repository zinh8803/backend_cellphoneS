<?php

namespace App\Services;

use App\Repositories\BrandRepository;

class BrandService
{
    protected BrandRepository $brandRepository;

    public function __construct(BrandRepository $brandRepository)
    {
        $this->brandRepository = $brandRepository;
    }

    public function all($params = [])
    {
        return $this->brandRepository->all($params);
    }

    public function search($params = [])
    {
        return $this->brandRepository->search($params);
    }

    public function show($id)
    {
        return $this->brandRepository->show($id);
    }

    public function store(array $data)
    {
        return $this->brandRepository->store($data);
    }

    public function update($id, array $data = [])
    {
        return $this->brandRepository->update($id, $data);
    }

    public function destroy($id)
    {
        return $this->brandRepository->destroy($id);
    }
}
