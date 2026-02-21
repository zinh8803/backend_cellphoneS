<?php

namespace App\Http\Requests\BranchProduct;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     schema="UpdateBranchProductRequest",
 *     type="object",
 *     @OA\Property(property="branch_id", type="integer"),
 *     @OA\Property(property="product_variant_id", type="integer"),
 *     @OA\Property(property="price", type="number", format="float"),
 *     @OA\Property(property="status", type="enum", enum={"active", "inactive"}),
 * )
 */
class UpdateBranchProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'branch_id' => 'sometimes|integer|exists:branches,id',
            'product_variant_id' => 'sometimes|integer|exists:product_variants,id',
            'price' => 'sometimes|nullable|numeric|min:0',
            'status' => 'sometimes|nullable|in:active,inactive',
        ];
    }
}
