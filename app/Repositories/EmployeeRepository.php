<?php

namespace App\Repositories;

use App\Core\BasicRepository;
use App\Models\Employee;

class EmployeeRepository extends BasicRepository
{
    public function __construct(Employee $EmployeeModel)
    {
        parent::__construct($EmployeeModel);
    }

    public function search($params = [])
    {
        $query = $this->model->newQuery();

        return $this->paging($query);
    }
}