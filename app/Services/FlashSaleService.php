<?php

namespace App\Services;

use App\Repositories\FlashSaleRepository;

class FlashSaleService
{
    protected FlashSaleRepository $FlashSaleRepository;

    public function __construct(FlashSaleRepository $FlashSaleRepository)
    {
        $this->FlashSaleRepository = $FlashSaleRepository;
    }

    public function all($params = [])
    {
        return $this->FlashSaleRepository->all($params);
    }

    public function search($params = [])
    {
        return $this->FlashSaleRepository->search($params);
    }

    public function show($id)
    {
        return $this->FlashSaleRepository->show($id);
    }

    public function store(array $data)
    {
        return $this->FlashSaleRepository->store($data);
    }

    public function update($id, array $data = [])
    {
        return $this->FlashSaleRepository->update($id, $data);
    }

    public function destroy($id)
    {
        return $this->FlashSaleRepository->destroy($id);
    }
}