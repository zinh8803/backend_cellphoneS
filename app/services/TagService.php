<?php

namespace App\Services;

use App\Repositories\TagRepository;

class TagService
{
    protected TagRepository $tagRepository;

    public function __construct(TagRepository $tagRepository)
    {
        $this->tagRepository = $tagRepository;
    }

    public function all($params = [])
    {
        return $this->tagRepository->all($params);
    }

    public function search($params = [])
    {
        return $this->tagRepository->search($params);
    }

    public function show($id)
    {
        return $this->tagRepository->show($id);
    }

    public function store(array $data)
    {
        return $this->tagRepository->store($data);
    }

    public function update($id, array $data = [])
    {
        return $this->tagRepository->update($id, $data);
    }

    public function destroy($id)
    {
        return $this->tagRepository->destroy($id);
    }
}
