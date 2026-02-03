<?php

namespace App\Services;

use App\Repositories\EmployeeRepository;

class EmployeeService
{
    protected EmployeeRepository $EmployeeRepository;

    public function __construct(EmployeeRepository $EmployeeRepository)
    {
        $this->EmployeeRepository = $EmployeeRepository;
    }

    public function all($params = [])
    {
        return $this->EmployeeRepository->all($params);
    }

    public function search($params = [])
    {
        return $this->EmployeeRepository->search($params);
    }

    public function show($id)
    {
        return $this->EmployeeRepository->show($id);
    }

    public function store(array $data)
    {
        return $this->EmployeeRepository->store($data);
    }

    public function update($id, array $data = [])
    {
        return $this->EmployeeRepository->update($id, $data);
    }

    public function destroy($id)
    {
        return $this->EmployeeRepository->destroy($id);
    }
}