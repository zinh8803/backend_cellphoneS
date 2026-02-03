<?php

namespace App\Http\Requests\BranchProduct;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     schema="StoreBranchProductRequest",
 *     type="object",
 *     @OA\Property(property="branch_id", type="integer"),
 *     @OA\Property(property="product_variant_id", type="integer"),
 *     @OA\Property(property="price", type="string"),
 *     @OA\Property(property="stock", type="string"),
 *     @OA\Property(property="status", type="string"),
 *     @OA\Property(property="created_at", type="string"),
 * )
 */
class StoreBranchProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'branch_id' => 'sometimes|integer',
            'product_variant_id' => 'sometimes|integer',
            'price' => 'sometimes|nullable|string',
            'stock' => 'sometimes|nullable|string',
            'status' => 'sometimes|nullable|string',
            'created_at' => 'sometimes|nullable|string',
        ];
    }
}