<?php

namespace App\Http\Requests\CouponUsage;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     schema="UpdateCouponUsageRequest",
 *     type="object",
 *     @OA\Property(property="coupon_id", type="integer"),
 *     @OA\Property(property="user_id", type="integer"),
 *     @OA\Property(property="order_id", type="integer"),
 *     @OA\Property(property="used_at", type="string"),
 * )
 */
class UpdateCouponUsageRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'coupon_id' => 'sometimes|integer',
            'user_id' => 'sometimes|integer',
            'order_id' => 'sometimes|integer',
            'used_at' => 'sometimes|nullable|string',
        ];
    }
}