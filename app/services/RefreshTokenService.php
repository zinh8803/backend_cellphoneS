<?php

namespace App\Services;

use App\Repositories\RefreshTokenRepository;

class RefreshTokenService
{
    protected RefreshTokenRepository $RefreshTokenRepository;

    public function __construct(RefreshTokenRepository $RefreshTokenRepository)
    {
        $this->RefreshTokenRepository = $RefreshTokenRepository;
    }

    public function all($params = [])
    {
        return $this->RefreshTokenRepository->all($params);
    }

    public function search($params = [])
    {
        return $this->RefreshTokenRepository->search($params);
    }

    public function show($id)
    {
        return $this->RefreshTokenRepository->show($id);
    }

    public function store(array $data)
    {
        return $this->RefreshTokenRepository->store($data);
    }

    public function update($id, array $data = [])
    {
        return $this->RefreshTokenRepository->update($id, $data);
    }

    public function destroy($id)
    {
        return $this->RefreshTokenRepository->destroy($id);
    }
}