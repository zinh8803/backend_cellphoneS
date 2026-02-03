<?php

namespace App\Services;

use App\Repositories\CategoryRepository;

class CategoryService
{
    protected CategoryRepository $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function all($params = [])
    {
        return $this->categoryRepository->all($params);
    }

    public function search($params = [])
    {
        return $this->categoryRepository->search($params);
    }

    public function show($id)
    {
        return $this->categoryRepository->show($id);
    }

    public function store(array $data)
    {
        return $this->categoryRepository->store($data);
    }

    public function update($id, array $data = [])
    {
        return $this->categoryRepository->update($id, $data);
    }

    public function destroy($id)
    {
        return $this->categoryRepository->destroy($id);
    }
}
