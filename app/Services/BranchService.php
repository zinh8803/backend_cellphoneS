<?php

namespace App\Services;

use App\Repositories\BranchRepository;

class BranchService
{
    protected BranchRepository $BranchRepository;

    public function __construct(BranchRepository $BranchRepository)
    {
        $this->BranchRepository = $BranchRepository;
    }

    public function all($params = [])
    {
        return $this->BranchRepository->all($params);
    }

    public function search($params = [])
    {
        return $this->BranchRepository->search($params);
    }

    public function show($id)
    {
        return $this->BranchRepository->show($id);
    }

    public function store(array $data)
    {
        return $this->BranchRepository->store($data);
    }

    public function update($id, array $data = [])
    {
        return $this->BranchRepository->update($id, $data);
    }

    public function destroy($id)
    {
        return $this->BranchRepository->destroy($id);
    }
}