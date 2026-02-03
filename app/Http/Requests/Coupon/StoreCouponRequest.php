<?php

namespace App\Http\Requests\Coupon;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     schema="StoreCouponRequest",
 *     type="object",
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
class StoreCouponRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'code' => 'sometimes|nullable|string',
            'discount_type' => 'sometimes|nullable|string',
            'discount_value' => 'sometimes|nullable|string',
            'min_order_value' => 'sometimes|nullable|string',
            'max_discount' => 'sometimes|nullable|string',
            'max_total_usage' => 'sometimes|nullable|string',
            'max_per_user' => 'sometimes|nullable|string',
            'allow_with_sale' => 'sometimes|nullable|string',
            'start_at' => 'sometimes|nullable|string',
            'end_at' => 'sometimes|nullable|string',
            'status' => 'sometimes|nullable|string',
        ];
    }
}