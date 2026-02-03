<?php

namespace App\Http\Requests\Storage;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     schema="StoreStorageRequest",
 *     type="object",
 *     @OA\Property(property="label", type="string"),
 * )
 */
class StoreStorageRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'label' => 'sometimes|nullable|string',
        ];
    }
}