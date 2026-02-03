<?php

namespace App\Http\Requests\ProductTag;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     schema="UpdateProductTagRequest",
 *     type="object",
 *     @OA\Property(property="product_id", type="integer"),
 *     @OA\Property(property="tag_id", type="integer"),
 * )
 */
class UpdateProductTagRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'product_id' => 'sometimes|integer',
            'tag_id' => 'sometimes|integer',
        ];
    }
}