<?php

namespace App\Http\Requests\RefreshToken;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     schema="UpdateRefreshTokenRequest",
 *     type="object",
 *     @OA\Property(property="token", type="string"),
 *     @OA\Property(property="user_id", type="integer"),
 *     @OA\Property(property="expires_at", type="string"),
 *     @OA\Property(property="ip_address", type="string"),
 *     @OA\Property(property="user_agent", type="string"),
 * )
 */
class UpdateRefreshTokenRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'token' => 'sometimes|nullable|string',
            'user_id' => 'sometimes|integer',
            'expires_at' => 'sometimes|nullable|string',
            'ip_address' => 'sometimes|nullable|string',
            'user_agent' => 'sometimes|nullable|string',
        ];
    }
}