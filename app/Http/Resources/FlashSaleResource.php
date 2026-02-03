<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     schema="FlashSale",
 *     type="object",
 *     @OA\Property(property="id", type="integer"),
 *     @OA\Property(property="branch_product_id", type="integer"),
 *     @OA\Property(property="discount_type", type="string"),
 *     @OA\Property(property="discount_value", type="string"),
 *     @OA\Property(property="start_at", type="string"),
 *     @OA\Property(property="end_at", type="string"),
 *     @OA\Property(property="is_stackable", type="boolean"),
 *     @OA\Property(property="status", type="string"),
 * )
 */
class FlashSaleResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'branch_product_id' => $this->branch_product_id,
            'discount_type' => $this->discount_type,
            'discount_value' => $this->discount_value,
            'start_at' => $this->start_at,
            'end_at' => $this->end_at,
            'is_stackable' => $this->is_stackable,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}