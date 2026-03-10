<?php

namespace App\Services;

use App\Models\BranchProduct;
use App\Models\Cart;
use App\Models\CartDetail;
use App\Repositories\CartRepository;
use Illuminate\Support\Facades\DB;

class CartService
{
    protected CartRepository $CartRepository;

    public function __construct(CartRepository $CartRepository)
    {
        $this->CartRepository = $CartRepository;
    }

    public function all($params = [])
    {
        return $this->CartRepository->all($params);
    }

    public function search($params = [])
    {
        return $this->CartRepository->search($params);
    }

    public function show($id)
    {
        return $this->CartRepository->show($id);
    }

    public function store(array $data)
    {
        return $this->CartRepository->store($data);
    }

    public function update($id, array $data = [])
    {
        return $this->CartRepository->update($id, $data);
    }

    public function destroy($id)
    {
        return $this->CartRepository->destroy($id);
    }

    public function addToCart(int $userId, int $branchProductId, int $quantity)
    {
        return DB::transaction(function () use ($userId, $branchProductId, $quantity) {
            if ($quantity < 1) {
                throw new \RuntimeException('Quantity must be at least 1.');
            }

            $branchProduct = BranchProduct::query()
                ->whereKey($branchProductId)
                ->lockForUpdate()
                ->first();

            if (!$branchProduct) {
                throw new \RuntimeException('Branch product not found.');
            }

            $availableStock = (int) ($branchProduct->stock ?? 0);

            $cart = Cart::query()
                ->where('user_id', $userId)
                ->lockForUpdate()
                ->first();

            if (!$cart) {
                $cart = Cart::query()->create(['user_id' => $userId]);
            }

            $detail = CartDetail::query()
                ->where('cart_id', $cart->id)
                ->where('branch_product_id', $branchProductId)
                ->lockForUpdate()
                ->first();

            $currentQty = (int) ($detail->quantity ?? 0);
            $newQty = $currentQty + $quantity;

            if ($newQty > $availableStock) {
                throw new \RuntimeException('Insufficient stock.');
            }

            if ($detail) {
                $detail->quantity = $newQty;
                $detail->save();
            } else {
                $detail = CartDetail::query()->create([
                    'cart_id' => $cart->id,
                    'branch_product_id' => $branchProductId,
                    'quantity' => $newQty,
                ]);
            }

            return $detail->fresh();
        });
    }
}
