<?php

namespace App\Http\Requests\InventoryTransactionItem;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     schema="UpdateInventoryTransactionItemRequest",
 *     type="object",
 *     @OA\Property(property="transaction_id", type="integer"),
 *     @OA\Property(property="branch_product_id", type="integer"),
 *     @OA\Property(property="quantity", type="string"),
 *     @OA\Property(property="unit_price", type="string"),
 * )
 */
class UpdateInventoryTransactionItemRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'transaction_id' => 'sometimes|integer',
            'branch_product_id' => 'sometimes|integer',
            'quantity' => 'sometimes|nullable|string',
            'unit_price' => 'sometimes|nullable|string',
        ];
    }
}