<?php

namespace App\Http\Requests\ProductImage;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     schema="StoreProductImageRequest",
 *     type="object",
 *     @OA\Property(property="product_id", type="integer"),
 *     @OA\Property(property="image_id", type="integer"),
 *     @OA\Property(property="is_primary", type="boolean"),
 * )
 */
class StoreProductImageRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'product_id' => 'sometimes|integer',
            'image_id' => 'sometimes|integer',
            'is_primary' => 'sometimes|boolean',
        ];
    }
}