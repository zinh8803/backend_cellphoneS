<?php

namespace App\Services;

use App\Repositories\ImageRepository;

class ImageService
{
    protected ImageRepository $imageRepository;

    public function __construct(ImageRepository $imageRepository)
    {
        $this->imageRepository = $imageRepository;
    }

    public function all($params = [])
    {
        return $this->imageRepository->all($params);
    }

    public function search($params = [])
    {
        return $this->imageRepository->search($params);
    }

    public function show($id)
    {
        return $this->imageRepository->show($id);
    }

    public function store(array $data)
    {
        return $this->imageRepository->store($data);
    }

    public function update($id, array $data = [])
    {
        return $this->imageRepository->update($id, $data);
    }

    public function destroy($id)
    {
        return $this->imageRepository->destroy($id);
    }
}
