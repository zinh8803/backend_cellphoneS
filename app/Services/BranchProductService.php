<?php

namespace App\Services;

use App\Repositories\BranchProductRepository;

class BranchProductService
{
    protected BranchProductRepository $BranchProductRepository;

    public function __construct(BranchProductRepository $BranchProductRepository)
    {
        $this->BranchProductRepository = $BranchProductRepository;
    }

    public function all($params = [])
    {
        return $this->BranchProductRepository->all($params);
    }

    public function search($params = [])
    {
        return $this->BranchProductRepository->search($params);
    }

    public function show($id)
    {
        return $this->BranchProductRepository->show($id);
    }

    public function store(array $data)
    {
        return $this->BranchProductRepository->store($data);
    }

    public function update($id, array $data = [])
    {
        return $this->BranchProductRepository->update($id, $data);
    }

    public function destroy($id)
    {
        return $this->BranchProductRepository->destroy($id);
    }
}
