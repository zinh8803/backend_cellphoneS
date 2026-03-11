<?php

namespace App\Repositories;

use App\Core\BasicRepository;
use App\Models\BranchProduct;
use App\Models\InventoryTransaction;
use App\Models\InventoryType;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

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

                $multiplier = $this->resolveStockMultiplier($transaction->inventory_type_id);
                foreach ($items as $item) {
                    $branchProductId = Arr::get($item, 'branch_product_id');
                    $quantity = (int) Arr::get($item, 'quantity', 0);

                    if (empty($branchProductId) || $quantity === 0) {
                        continue;
                    }

                    $branchProduct = BranchProduct::query()
                        ->whereKey($branchProductId)
                        ->lockForUpdate()
                        ->first();

                    if (!$branchProduct) {
                        throw new \RuntimeException('Branch product not found: ' . $branchProductId);
                    }

                    if ((int) $branchProduct->branch_id !== (int) $transaction->branch_id) {
                        throw new \RuntimeException('Branch product does not belong to this branch.');
                    }

                    $delta = $multiplier * $quantity;
                    $currentStock = (int) ($branchProduct->stock ?? 0);
                    $newStock = $currentStock + $delta;

                    if ($newStock < 0) {
                        throw new \RuntimeException('Insufficient stock for branch_product_id: ' . $branchProductId);
                    }

                    $branchProduct->stock = $newStock;
                    $branchProduct->save();
                }
            }

            return $transaction->load('items');
        });
    }

    protected function resolveStockMultiplier($inventoryTypeId): int
    {
        $inventoryType = InventoryType::query()->find($inventoryTypeId);

        $haystack = Str::lower(Str::ascii(trim(
            (string) ($inventoryType->code ?? '') . ' ' . (string) ($inventoryType->name ?? '')
        )));

        if (Str::contains($haystack, ['out', 'export', 'xuat', 'issue', 'remove', 'decrease'])) {
            return -1;
        }

        return 1;
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
