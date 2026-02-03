<?php

namespace App\Http\Requests\UserAddress;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     schema="UpdateUserAddressRequest",
 *     type="object",
 *     @OA\Property(property="user_id", type="integer"),
 *     @OA\Property(property="city_id", type="integer"),
 *     @OA\Property(property="ward_id", type="integer"),
 *     @OA\Property(property="detail", type="string"),
 *     @OA\Property(property="receiver_name", type="string"),
 *     @OA\Property(property="phone", type="string"),
 *     @OA\Property(property="is_default", type="boolean"),
 *     @OA\Property(property="created_at", type="string"),
 * )
 */
class UpdateUserAddressRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'user_id' => 'sometimes|integer',
            'city_id' => 'sometimes|integer',
            'ward_id' => 'sometimes|integer',
            'detail' => 'sometimes|nullable|string',
            'receiver_name' => 'sometimes|nullable|string',
            'phone' => 'sometimes|nullable|string',
            'is_default' => 'sometimes|boolean',
            'created_at' => 'sometimes|nullable|string',
        ];
    }
}