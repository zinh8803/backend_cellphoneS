<?php

namespace App\Services;

use App\Repositories\ColorRepository;

class ColorService
{
    protected ColorRepository $colorRepository;

    public function __construct(ColorRepository $colorRepository)
    {
        $this->colorRepository = $colorRepository;
    }

    public function all($params = [])
    {
        return $this->colorRepository->all($params);
    }

    public function search($params = [])
    {
        return $this->colorRepository->search($params);
    }

    public function show($id)
    {
        return $this->colorRepository->show($id);
    }

    public function store(array $data)
    {
        return $this->colorRepository->store($data);
    }

    public function update($id, array $data = [])
    {
        return $this->colorRepository->update($id, $data);
    }

    public function destroy($id)
    {
        return $this->colorRepository->destroy($id);
    }
}
