<?php

namespace App\Http\Requests\ProductVariant;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     schema="StoreProductVariantRequest",
 *     type="object",
 *     @OA\Property(property="product_id", type="integer"),
 *     @OA\Property(property="color_id", type="integer"),
 *     @OA\Property(property="storage_id", type="integer"),
 * )
 */
class StoreProductVariantRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'product_id' => 'required|integer|exists:products,id',
            'color_id' => 'required|integer|exists:colors,id',
            'storage_id' => 'required|integer|exists:storages,id',
        ];
    }
}
