<?php

namespace App\Repositories;

use App\Core\BasicRepository;
use App\Models\InventoryTransaction;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class InventoryTransactionRepository extends BasicRepository
{
    public function __construct(InventoryTransaction $InventoryTransactionModel)
    {
        parent::__construct($InventoryTransactionModel);
    }

    public function search($params = [])
    {
        $query = $this->model->newQuery();

        $keyword = $params['keyword'] ?? request()->get('keyword');
        if (!empty($keyword)) {
            $query->where(function ($q) use ($keyword) {
                $q->where('code', 'like', "%{$keyword}%");
            });
        }

        return $this->paging($query);
    }

    public function show($id)
    {
        return $this->model->with('items')->find($id);
    }

    public function store($data)
    {
        return DB::transaction(function () use ($data) {
            $items = Arr::get($data, 'items', []);

            $transaction = $this->model->create(Arr::except($data, ['items']));

            if (!empty($items)) {
                $transaction->items()->createMany($items);
            }

            return $transaction->load('items');
        });
    }

    public function update($id, $data = [])
    {
        $model = $this->model->find($id);
        if ($model) {
            $model->update(Arr::except($data, ['items']));
            // Optionally update items here if needed
        }
        return $model ? $model->load('items') : null;
    }
}
