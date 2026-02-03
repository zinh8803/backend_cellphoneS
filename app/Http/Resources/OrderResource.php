<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     schema="Order",
 *     type="object",
 *     @OA\Property(property="id", type="integer"),
 *     @OA\Property(property="user_id", type="integer"),
 *     @OA\Property(property="branch_id", type="integer"),
 *     @OA\Property(property="total_amount", type="string"),
 *     @OA\Property(property="status", type="string"),
 *     @OA\Property(property="coupon_id", type="integer"),
 *     @OA\Property(property="discount_amount", type="string"),
 *     @OA\Property(property="created_at", type="string"),
 * )
 */
class OrderResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'branch_id' => $this->branch_id,
            'total_amount' => $this->total_amount,
            'status' => $this->status,
            'coupon_id' => $this->coupon_id,
            'discount_amount' => $this->discount_amount,
            'created_at' => $this->created_at,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}