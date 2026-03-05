<?php

namespace App\Http\Requests\UserAddress;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     schema="StoreUserAddressRequest",
 *     type="object",
 *     @OA\Property(property="city_id", type="integer"),
 *     @OA\Property(property="ward_id", type="integer"),
 *     @OA\Property(property="detail", type="string"),
 *     @OA\Property(property="receiver_name", type="string"),
 *     @OA\Property(property="phone", type="string",example="0909123456"),
 *     @OA\Property(property="is_default", type="boolean")
 * )
 */
class StoreUserAddressRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'city_id' => 'sometimes|integer',
            'ward_id' => 'sometimes|integer',
            'detail' => 'sometimes|nullable|string',
            'receiver_name' => 'sometimes|nullable|string',
            'phone' => [
                'sometimes',
                'string',
                'max:20',
                'regex:/^(0[1-9][0-9]{8,9})$/',
            ],
            'is_default' => 'sometimes|boolean',
        ];
    }
    public function messages(): array
    {
        return [
            'phone.regex' => 'số điện thoại không hợp lệ, phải bắt đầu bằng 0 và có 10 hoặc 11 chữ số.',
        ];
    }
}
