<?php

namespace App\Http\Requests\FlashSale;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     schema="StoreFlashSaleRequest",
 *     type="object",
 *     @OA\Property(property="branch_product_id", type="integer"),
 *     @OA\Property(property="discount_type", type="string"),
 *     @OA\Property(property="discount_value", type="string"),
 *     @OA\Property(property="start_at", type="string"),
 *     @OA\Property(property="end_at", type="string"),
 *     @OA\Property(property="is_stackable", type="boolean"),
 *     @OA\Property(property="status", type="string"),
 * )
 */
class StoreFlashSaleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'branch_product_id' => 'sometimes|integer',
            'discount_type' => 'sometimes|nullable|string',
            'discount_value' => 'sometimes|nullable|string',
            'start_at' => 'sometimes|nullable|string',
            'end_at' => 'sometimes|nullable|string',
            'is_stackable' => 'sometimes|boolean',
            'status' => 'sometimes|nullable|string',
        ];
    }
}