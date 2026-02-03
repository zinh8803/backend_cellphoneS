<?php

namespace App\Http\Requests\Ward;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     schema="UpdateWardRequest",
 *     type="object",
 *     @OA\Property(property="district_id", type="integer"),
 *     @OA\Property(property="name", type="string"),
 * )
 */
class UpdateWardRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'district_id' => 'sometimes|integer',
            'name' => 'sometimes|nullable|string',
        ];
    }
}