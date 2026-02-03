<?php

namespace App\Http\Requests\Tag;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     schema="StoreTagRequest",
 *     required={"name", "slug"},
 *     @OA\Property(property="name", type="string", example="Hot"),
 *     @OA\Property(property="slug", type="string", example="hot"),
 * )
 */
class StoreTagRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255|unique:tags,name',
            'slug' => 'required|string|max:255|unique:tags,slug',
        ];
    }
}
