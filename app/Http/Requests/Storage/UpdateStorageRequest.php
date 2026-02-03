<?php

namespace App\Http\Requests\Storage;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     schema="UpdateStorageRequest",
 *     type="object",
 *     @OA\Property(property="label", type="string"),
 * )
 */
class UpdateStorageRequest extends FormRequest
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