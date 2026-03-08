<?php

namespace App\Services;

use App\Repositories\AttributeRepository;

class AttributeService
{
    protected AttributeRepository $attributeRepository;

    public function __construct(AttributeRepository $attributeRepository)
    {
        $this->attributeRepository = $attributeRepository;
    }

    public function all($params = [])
    {
        return $this->attributeRepository->all($params);
    }

    public function search($params = [])
    {
        return $this->attributeRepository->search($params);
    }

    public function show($id)
    {
        return $this->attributeRepository->show($id);
    }

    public function store(array $data)
    {
        return $this->attributeRepository->store($data);
    }

    public function update($id, array $data = [])
    {
        return $this->attributeRepository->update($id, $data);
    }

    public function destroy($id)
    {
        return $this->attributeRepository->destroy($id);
    }
}
