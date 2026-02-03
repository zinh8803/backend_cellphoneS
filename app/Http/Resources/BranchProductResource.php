<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     schema="BranchProduct",
 *     type="object",
 *     @OA\Property(property="id", type="integer"),
 *     @OA\Property(property="branch_id", type="integer"),
 *     @OA\Property(property="product_variant_id", type="integer"),
 *     @OA\Property(property="price", type="string"),
 *     @OA\Property(property="stock", type="string"),
 *     @OA\Property(property="status", type="string"),
 *     @OA\Property(property="created_at", type="string"),
 * )
 */
class BranchProductResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'branch_id' => $this->branch_id,
            'product_variant_id' => $this->product_variant_id,
            'price' => $this->price,
            'stock' => $this->stock,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}