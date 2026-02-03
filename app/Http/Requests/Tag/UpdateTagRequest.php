<?php

namespace App\Http\Requests\Tag;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     schema="UpdateTagRequest",
 *     @OA\Property(property="name", type="string", example="Hot"),
 *     @OA\Property(property="slug", type="string", example="hot"),
 * )
 */
class UpdateTagRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = $this->route('id');

        return [
            'name' => 'sometimes|required|string|max:255|unique:tags,name,' . $id,
            'slug' => 'sometimes|required|string|max:255|unique:tags,slug,' . $id,
        ];
    }
}
