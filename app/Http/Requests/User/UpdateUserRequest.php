<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     schema="UpdateUserRequest",
 *     type="object",
 *     @OA\Property(property="name", type="string"),
 *     @OA\Property(property="email", type="string"),
 *     @OA\Property(property="password", type="string"),
 *     @OA\Property(property="role_id", type="integer"),
 *     @OA\Property(property="image_url", type="string"),
 *     @OA\Property(property="uuid", type="string"),
 * )
 */
class UpdateUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'sometimes|nullable|string|max:255',
            'phone' => 'sometimes|nullable|string|max:20',
            'gender' => 'sometimes|nullable|in:male,female,other',
            'status' => 'sometimes|nullable|in:active,inactive',
            'image_url' => 'sometimes|nullable|url',
            'image' => 'sometimes|nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];
    }
}
