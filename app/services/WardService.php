<?php

namespace App\Services;

use App\Repositories\WardRepository;

class WardService
{
    protected WardRepository $WardRepository;

    public function __construct(WardRepository $WardRepository)
    {
        $this->WardRepository = $WardRepository;
    }

    public function all($params = [])
    {
        return $this->WardRepository->all($params);
    }

    public function search($params = [])
    {
        return $this->WardRepository->search($params);
    }

    public function show($id)
    {
        return $this->WardRepository->show($id);
    }

    public function store(array $data)
    {
        return $this->WardRepository->store($data);
    }

    public function update($id, array $data = [])
    {
        return $this->WardRepository->update($id, $data);
    }

    public function destroy($id)
    {
        return $this->WardRepository->destroy($id);
    }
}