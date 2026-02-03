<?php

namespace App\Services;

use App\Repositories\ReviewRepository;

class ReviewService
{
    protected ReviewRepository $ReviewRepository;

    public function __construct(ReviewRepository $ReviewRepository)
    {
        $this->ReviewRepository = $ReviewRepository;
    }

    public function all($params = [])
    {
        return $this->ReviewRepository->all($params);
    }

    public function search($params = [])
    {
        return $this->ReviewRepository->search($params);
    }

    public function show($id)
    {
        return $this->ReviewRepository->show($id);
    }

    public function store(array $data)
    {
        return $this->ReviewRepository->store($data);
    }

    public function update($id, array $data = [])
    {
        return $this->ReviewRepository->update($id, $data);
    }

    public function destroy($id)
    {
        return $this->ReviewRepository->destroy($id);
    }
}