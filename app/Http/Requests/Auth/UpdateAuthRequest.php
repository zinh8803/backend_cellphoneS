<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Summary of UpdateAuthRequest
 * @OA\Schema(
 *     schema="UpdateAuthRequest",
 *     @OA\Property(property="_method", type="string", example="PUT"),
 *     @OA\Property(property="name", type="string", nullable=true, example="John Doe"),
 *     @OA\Property(property="phone", type="string", nullable=true, example="+1234567890"),
 *     @OA\Property(property="gender", type="string", nullable=true, example="male"),
 *     @OA\Property(property="image", type="string", format="binary", nullable=true, description="Ảnh đại diện người dùng"),
 * )    
 */
class UpdateAuthRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Allow all authenticated users to update their own info
        return auth('api')->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'sometimes|nullable|string|max:255',
            'phone' => 'sometimes|nullable|string|max:20',
            'gender' => 'sometimes|nullable|in:male,female,other',
            'image' => 'sometimes|nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];
    }
}
