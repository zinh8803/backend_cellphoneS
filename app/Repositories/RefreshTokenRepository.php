<?php

namespace App\Repositories;

use App\Core\BasicRepository;
use App\Models\RefreshToken;
use Illuminate\Support\Facades\Hash;

class RefreshTokenRepository extends BasicRepository
{
    public function __construct(RefreshToken $RefreshTokenModel)
    {
        parent::__construct($RefreshTokenModel);
    }

    public function search($params = [])
    {
        $query = $this->model->newQuery();

        return $this->paging($query);
    }

    public function getByToken($token)
    {
        $candidates = $this->model
            ->where(function ($query) {
                $query->whereNull('expires_at')->orWhere('expires_at', '>', now());
            })
            ->orderByDesc('id')
            ->get();

        foreach ($candidates as $candidate) {
            if ($candidate->token === $token || Hash::check($token, $candidate->token)) {
                return $candidate;
            }
        }

        return null;
    }

    public function deleteById(int $id): void
    {
        $this->model->where('id', $id)->delete();
    }

    public function deleteByUserId(int $userId): void
    {
        $this->model->where('user_id', $userId)->delete();
    }

    public function store($data)
    {
        return parent::store($data);
    }
    public function create(array $data)
    {
        return $this->store($data);
    }
}
