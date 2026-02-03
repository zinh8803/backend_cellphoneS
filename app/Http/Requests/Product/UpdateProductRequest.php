<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     schema="UpdateProductRequest",
 *     @OA\Property(property="name", type="string", example="iPhone 15"),
 *     @OA\Property(property="slug", type="string", example="iphone-15"),
 *     @OA\Property(property="description", type="string", example="..."),
 *     @OA\Property(property="brand_id", type="integer", example=1),
 *     @OA\Property(property="category_id", type="integer", example=1),
 *     @OA\Property(property="tag_ids", type="array", @OA\Items(type="integer"), example={1,2}),
 *     @OA\Property(
 *         property="images",
 *         type="array",
 *         @OA\Items(
 *             type="object",
 *             @OA\Property(property="id", type="integer", example=1),
 *             @OA\Property(property="url", type="string", example="https://example.com/image.jpg"),
 *             @OA\Property(property="is_primary", type="boolean", example=true),
 *         )
 *     ),
 * )
 */
class UpdateProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'sometimes|required|string|max:255',
            'slug' => 'sometimes|nullable|string|max:255',
            'description' => 'sometimes|nullable|string',
            'brand_id' => 'sometimes|required|integer|exists:brands,id',
            'category_id' => 'sometimes|required|integer|exists:categories,id',
            'tag_ids' => 'sometimes|array',
            'tag_ids.*' => 'integer|exists:tags,id',
            'image_ids' => 'sometimes|array',
            'image_ids.*' => 'integer|exists:images,id',
            'images' => 'sometimes|array',
            'images.*.id' => 'sometimes|integer|exists:images,id',
            'images.*.url' => 'sometimes|string',
            'images.*.is_primary' => 'sometimes|boolean',
        ];
    }
}
