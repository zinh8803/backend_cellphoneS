<?php

namespace App\Services;

use App\Repositories\CityRepository;

class CityService
{
    protected CityRepository $CityRepository;

    public function __construct(CityRepository $CityRepository)
    {
        $this->CityRepository = $CityRepository;
    }

    public function all($params = [])
    {
        return $this->CityRepository->all($params);
    }

    public function search($params = [])
    {
        return $this->CityRepository->search($params);
    }

    public function show($id)
    {
        return $this->CityRepository->show($id);
    }

    public function store(array $data)
    {
        return $this->CityRepository->store($data);
    }

    public function update($id, array $data = [])
    {
        return $this->CityRepository->update($id, $data);
    }

    public function destroy($id)
    {
        return $this->CityRepository->destroy($id);
    }
}