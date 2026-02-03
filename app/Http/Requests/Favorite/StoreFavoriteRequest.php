<?php

namespace App\Http\Requests\Favorite;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     schema="StoreFavoriteRequest",
 *     type="object",
 *     @OA\Property(property="user_id", type="integer"),
 *     @OA\Property(property="product_id", type="integer"),
 *     @OA\Property(property="created_at", type="string"),
 * )
 */
class StoreFavoriteRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'user_id' => 'sometimes|integer',
            'product_id' => 'sometimes|integer',
            'created_at' => 'sometimes|nullable|string',
        ];
    }
}