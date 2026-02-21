<?php

namespace App\Http\Requests\BranchProduct;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Log;

/**
 * @OA\Schema(
 *     schema="StoreBranchProductRequest",
 *     type="object",
 *     @OA\Property(property="branch_id", type="integer"),
 *     @OA\Property(property="product_variant_id", type="integer"),
 *     @OA\Property(property="price", type="number", format="float"),
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
            'branch_id' => 'required|integer|exists:branches,id',
            'product_variant_id' => 'required|integer|exists:product_variants,id',
            'price' => 'sometimes|nullable|numeric|min:0',
        ];
    }
}
