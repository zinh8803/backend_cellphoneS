<?php

namespace App\Http\Requests\Branch;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     schema="UpdateBranchRequest",
 *     type="object",
 *     @OA\Property(property="name", type="string"),
 *     @OA\Property(property="detail", type="string"),
 *     @OA\Property(property="city_id", type="integer"),
 *     @OA\Property(property="ward_id", type="integer"),
 * )
 */
class UpdateBranchRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'sometimes|nullable|string',
            'detail' => 'sometimes|nullable|string',
            'city_id' => 'sometimes|exists:cities,id',
            'ward_id' => 'sometimes|exists:wards,id',
        ];
    }
}
