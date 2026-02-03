<?php

namespace App\Http\Requests\Review;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     schema="UpdateReviewRequest",
 *     type="object",
 *     @OA\Property(property="user_id", type="integer"),
 *     @OA\Property(property="product_id", type="integer"),
 *     @OA\Property(property="rating", type="string"),
 *     @OA\Property(property="comment", type="string"),
 *     @OA\Property(property="created_at", type="string"),
 * )
 */
class UpdateReviewRequest extends FormRequest
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
            'rating' => 'sometimes|nullable|string',
            'comment' => 'sometimes|nullable|string',
            'created_at' => 'sometimes|nullable|string',
        ];
    }
}