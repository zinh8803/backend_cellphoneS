<?php

namespace App\Http\Requests\Image;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     schema="UpdateImageRequest",
 *     @OA\Property(property="url", type="string", example="https://example.com/image.jpg"),
 * )
 */
class UpdateImageRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'url' => 'sometimes|required|string',
        ];
    }
}
