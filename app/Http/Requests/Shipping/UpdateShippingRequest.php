<?php

namespace App\Http\Requests\Shipping;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     schema="UpdateShippingRequest",
 *     type="object",
 *     @OA\Property(property="order_id", type="integer"),
 *     @OA\Property(property="address", type="string"),
 *     @OA\Property(property="status", type="string"),
 *     @OA\Property(property="shipped_at", type="string"),
 *     @OA\Property(property="delivered_at", type="string"),
 * )
 */
class UpdateShippingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'order_id' => 'sometimes|integer',
            'address' => 'sometimes|nullable|string',
            'status' => 'sometimes|nullable|string',
            'shipped_at' => 'sometimes|nullable|string',
            'delivered_at' => 'sometimes|nullable|string',
        ];
    }
}