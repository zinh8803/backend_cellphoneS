<?php

namespace App\Services;

use App\Repositories\CouponUsageRepository;

class CouponUsageService
{
    protected CouponUsageRepository $CouponUsageRepository;

    public function __construct(CouponUsageRepository $CouponUsageRepository)
    {
        $this->CouponUsageRepository = $CouponUsageRepository;
    }

    public function all($params = [])
    {
        return $this->CouponUsageRepository->all($params);
    }

    public function search($params = [])
    {
        return $this->CouponUsageRepository->search($params);
    }

    public function show($id)
    {
        return $this->CouponUsageRepository->show($id);
    }

    public function store(array $data)
    {
        return $this->CouponUsageRepository->store($data);
    }

    public function update($id, array $data = [])
    {
        return $this->CouponUsageRepository->update($id, $data);
    }

    public function destroy($id)
    {
        return $this->CouponUsageRepository->destroy($id);
    }
}