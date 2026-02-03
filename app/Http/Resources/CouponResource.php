<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     schema="Coupon",
 *     type="object",
 *     @OA\Property(property="id", type="integer"),
 *     @OA\Property(property="code", type="string"),
 *     @OA\Property(property="discount_type", type="string"),
 *     @OA\Property(property="discount_value", type="string"),
 *     @OA\Property(property="min_order_value", type="string"),
 *     @OA\Property(property="max_discount", type="string"),
 *     @OA\Property(property="max_total_usage", type="string"),
 *     @OA\Property(property="max_per_user", type="string"),
 *     @OA\Property(property="allow_with_sale", type="string"),
 *     @OA\Property(property="start_at", type="string"),
 *     @OA\Property(property="end_at", type="string"),
 *     @OA\Property(property="status", type="string"),
 * )
 */
class CouponResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'code' => $this->code,
            'discount_type' => $this->discount_type,
            'discount_value' => $this->discount_value,
            'min_order_value' => $this->min_order_value,
            'max_discount' => $this->max_discount,
            'max_total_usage' => $this->max_total_usage,
            'max_per_user' => $this->max_per_user,
            'allow_with_sale' => $this->allow_with_sale,
            'start_at' => $this->start_at,
            'end_at' => $this->end_at,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}