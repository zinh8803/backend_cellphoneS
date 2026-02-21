<?php

namespace App\Http\Requests\ProductVariant;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     schema="UpdateProductVariantRequest",
 *     type="object",
 *     @OA\Property(property="product_id", type="integer"),
 *     @OA\Property(property="color_id", type="integer"),
 *     @OA\Property(property="storage_id", type="integer"),
 * )
 */
class UpdateProductVariantRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'product_id' => 'sometimes|integer|exists:products,id',
            'color_id' => 'sometimes|integer|exists:colors,id',
            'storage_id' => 'sometimes|integer|exists:storages,id',
        ];
    }
}
