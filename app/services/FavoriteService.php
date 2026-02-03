<?php

namespace App\Services;

use App\Repositories\FavoriteRepository;

class FavoriteService
{
    protected FavoriteRepository $FavoriteRepository;

    public function __construct(FavoriteRepository $FavoriteRepository)
    {
        $this->FavoriteRepository = $FavoriteRepository;
    }

    public function all($params = [])
    {
        return $this->FavoriteRepository->all($params);
    }

    public function search($params = [])
    {
        return $this->FavoriteRepository->search($params);
    }

    public function show($id)
    {
        return $this->FavoriteRepository->show($id);
    }

    public function store(array $data)
    {
        return $this->FavoriteRepository->store($data);
    }

    public function update($id, array $data = [])
    {
        return $this->FavoriteRepository->update($id, $data);
    }

    public function destroy($id)
    {
        return $this->FavoriteRepository->destroy($id);
    }
}