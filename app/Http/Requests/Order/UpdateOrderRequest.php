<?php

namespace App\Http\Requests\Order;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     schema="UpdateOrderRequest",
 *     type="object",
 *     @OA\Property(property="user_id", type="integer"),
 *     @OA\Property(property="branch_id", type="integer"),
 *     @OA\Property(property="total_amount", type="string"),
 *     @OA\Property(property="status", type="string"),
 *     @OA\Property(property="coupon_id", type="integer"),
 *     @OA\Property(property="discount_amount", type="string"),
 *     @OA\Property(property="created_at", type="string"),
 * )
 */
class UpdateOrderRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'user_id' => 'sometimes|integer',
            'branch_id' => 'sometimes|integer',
            'total_amount' => 'sometimes|nullable|string',
            'status' => 'sometimes|nullable|string',
            'coupon_id' => 'sometimes|integer',
            'discount_amount' => 'sometimes|nullable|string',
            'created_at' => 'sometimes|nullable|string',
        ];
    }
}