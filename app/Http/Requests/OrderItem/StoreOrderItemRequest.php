<?php

namespace App\Http\Requests\OrderItem;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     schema="StoreOrderItemRequest",
 *     type="object",
 *     @OA\Property(property="order_id", type="integer"),
 *     @OA\Property(property="branch_product_id", type="integer"),
 *     @OA\Property(property="quantity", type="string"),
 *     @OA\Property(property="price_snapshot", type="string"),
 * )
 */
class StoreOrderItemRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'order_id' => 'sometimes|integer',
            'branch_product_id' => 'sometimes|integer',
            'quantity' => 'sometimes|nullable|string',
            'price_snapshot' => 'sometimes|nullable|string',
        ];
    }
}