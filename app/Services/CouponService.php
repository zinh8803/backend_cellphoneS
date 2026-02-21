<?php

namespace App\Services;

use App\Repositories\CouponRepository;

class CouponService
{
    protected CouponRepository $CouponRepository;

    public function __construct(CouponRepository $CouponRepository)
    {
        $this->CouponRepository = $CouponRepository;
    }

    public function all($params = [])
    {
        return $this->CouponRepository->all($params);
    }

    public function search($params = [])
    {
        return $this->CouponRepository->search($params);
    }

    public function show($id)
    {
        return $this->CouponRepository->show($id);
    }

    public function store(array $data)
    {
        return $this->CouponRepository->store($data);
    }

    public function update($id, array $data = [])
    {
        return $this->CouponRepository->update($id, $data);
    }

    public function destroy($id)
    {
        return $this->CouponRepository->destroy($id);
    }
}