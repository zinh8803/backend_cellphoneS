<?php

namespace App\Http\Requests\InventoryTransaction;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     schema="UpdateInventoryTransactionRequest",
 *     type="object",
 *     @OA\Property(property="branch_id", type="integer"),
 *     @OA\Property(property="type_id", type="integer"),
 *     @OA\Property(property="code", type="string"),
 *     @OA\Property(property="note", type="string"),
 *     @OA\Property(property="created_by", type="string"),
 *     @OA\Property(property="created_at", type="string"),
 * )
 */
class UpdateInventoryTransactionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'branch_id' => 'sometimes|integer',
            'type_id' => 'sometimes|integer',
            'code' => 'sometimes|nullable|string',
            'note' => 'sometimes|nullable|string',
            'created_by' => 'sometimes|nullable|string',
            'created_at' => 'sometimes|nullable|string',
        ];
    }
}