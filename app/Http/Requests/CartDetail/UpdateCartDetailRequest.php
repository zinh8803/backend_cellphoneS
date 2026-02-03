<?php

namespace App\Http\Requests\CartDetail;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     schema="UpdateCartDetailRequest",
 *     type="object",
 *     @OA\Property(property="cart_id", type="integer"),
 *     @OA\Property(property="branch_product_id", type="integer"),
 *     @OA\Property(property="quantity", type="string"),
 * )
 */
class UpdateCartDetailRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'cart_id' => 'sometimes|integer',
            'branch_product_id' => 'sometimes|integer',
            'quantity' => 'sometimes|nullable|string',
        ];
    }
}