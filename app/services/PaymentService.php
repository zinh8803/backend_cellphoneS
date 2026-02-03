<?php

namespace App\Services;

use App\Repositories\PaymentRepository;

class PaymentService
{
    protected PaymentRepository $PaymentRepository;

    public function __construct(PaymentRepository $PaymentRepository)
    {
        $this->PaymentRepository = $PaymentRepository;
    }

    public function all($params = [])
    {
        return $this->PaymentRepository->all($params);
    }

    public function search($params = [])
    {
        return $this->PaymentRepository->search($params);
    }

    public function show($id)
    {
        return $this->PaymentRepository->show($id);
    }

    public function store(array $data)
    {
        return $this->PaymentRepository->store($data);
    }

    public function update($id, array $data = [])
    {
        return $this->PaymentRepository->update($id, $data);
    }

    public function destroy($id)
    {
        return $this->PaymentRepository->destroy($id);
    }
}