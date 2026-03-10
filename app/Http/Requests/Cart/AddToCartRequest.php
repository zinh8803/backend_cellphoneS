<?php

namespace App\Http\Requests\Cart;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     schema="AddToCartRequest",
 *     type="object",
 *     required={"branch_product_id","quantity"},
 *     @OA\Property(property="branch_product_id", type="integer", example=1),
 *     @OA\Property(property="quantity", type="integer", example=1),
 * )
 */
class AddToCartRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'branch_product_id' => 'required|integer|exists:branch_products,id',
            'quantity' => 'required|integer|min:1',
        ];
    }
}
