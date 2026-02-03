<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     schema="StoreUserRequest",
 *     type="object",
 *     @OA\Property(property="name", type="string"),
 *     @OA\Property(property="email", type="string"),
 *     @OA\Property(property="password", type="string"),
 *     @OA\Property(property="role_id", type="integer"),
 *     @OA\Property(property="image_url", type="string"),
 *     @OA\Property(property="uuid", type="string"),
 * )
 */
class StoreUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'sometimes|nullable|string',
            'email' => 'sometimes|nullable|string',
            'password' => 'sometimes|nullable|string',
            'role_id' => 'sometimes|integer',
            'image_url' => 'sometimes|nullable|string',
            'uuid' => 'sometimes|nullable|string',
        ];
    }
}