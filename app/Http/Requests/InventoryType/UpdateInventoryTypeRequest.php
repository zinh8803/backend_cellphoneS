<?php

namespace App\Http\Requests\InventoryType;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     schema="UpdateInventoryTypeRequest",
 *     type="object",
 *     @OA\Property(property="code", type="string"),
 *     @OA\Property(property="name", type="string"),
 * )
 */
class UpdateInventoryTypeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'code' => 'sometimes|nullable|string',
            'name' => 'sometimes|nullable|string',
        ];
    }
}