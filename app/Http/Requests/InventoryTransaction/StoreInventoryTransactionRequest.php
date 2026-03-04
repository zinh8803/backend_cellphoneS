<?php

namespace App\Http\Requests\InventoryTransaction;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     schema="StoreInventoryTransactionRequest",
 *     type="object",
 *     @OA\Property(property="branch_id", type="integer"),
 *     @OA\Property(property="inventory_type_id", type="integer"),
 *     @OA\Property(property="code", type="string"),
 *     @OA\Property(property="note", type="string"),
 *     @OA\Property(
 *         property="items",
 *         type="array",
 *         @OA\Items(
 *             type="object",
 *             @OA\Property(property="branch_product_id", type="integer"),
 *             @OA\Property(property="quantity", type="integer"),
 *             @OA\Property(property="unit_price", type="integer")
 *         )
 *     ),
 * )
 */
class StoreInventoryTransactionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'branch_id' => 'required|integer|exists:branches,id',
            'inventory_type_id' => 'required|integer|exists:inventory_types,id',
            'code' => 'sometimes|nullable|string',
            'note' => 'sometimes|nullable|string',
            'items' => 'required|array|min:1',
            'items.*.branch_product_id' => 'required|integer|exists:branch_products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.unit_price' => 'required|integer|min:0',
        ];
    }
}