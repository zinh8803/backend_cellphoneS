<?php

namespace App\Repositories;

use App\Core\BasicRepository;
use App\Models\BranchProduct;

class BranchProductRepository extends BasicRepository
{
    public function __construct(BranchProduct $BranchProductModel)
    {
        parent::__construct($BranchProductModel);
    }

    public function all($params = [])
    {
        $query = $this->model->newQuery()->with([
            'branch',
            'productVariant',
        ]);

        if (!empty($params['branch_id'])) {
            $query->where('branch_id', $params['branch_id']);
        }

        return $this->paging($query);
    }
    public function store($data)
    {
        return parent::store($data);
    }
    public function search($params = [])
    {
        $query = $this->model->newQuery();

        return $this->paging($query);
    }
}
