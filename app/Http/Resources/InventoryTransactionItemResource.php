<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     schema="InventoryTransactionItem",
 *     type="object",
 *     @OA\Property(property="id", type="integer"),
 *     @OA\Property(property="inventory_transaction_id", type="integer"),
 *     @OA\Property(property="branch_product_id", type="integer"),
 *     @OA\Property(property="quantity", type="integer"),
 *     @OA\Property(property="unit_price", type="integer"),
 * )
 */
class InventoryTransactionItemResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'inventory_transaction_id' => $this->inventory_transaction_id,
            'branch_product_id' => $this->branch_product_id,
            'quantity' => $this->quantity,
            'unit_price' => $this->unit_price,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}