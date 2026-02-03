<?php

namespace App\Http\Requests\Brand;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     schema="UpdateBrandRequest",
 *     @OA\Property(property="name", type="string", example="Apple"),
 *     @OA\Property(property="slug", type="string", example="apple"),
 * )
 */
class UpdateBrandRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = $this->route('id');

        return [
            'name' => 'sometimes|required|string|max:255|unique:brands,name,' . $id,
            'slug' => 'sometimes|required|string|max:255|unique:brands,slug,' . $id,
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Tên brand là bắt buộc.',
            'name.string' => 'Tên brand phải là chuỗi ký tự.',
            'name.max' => 'Tên brand không được vượt quá 255 ký tự.',
            'name.unique' => 'Tên brand đã tồn tại.',
            'slug.required' => 'Slug là bắt buộc.',
            'slug.string' => 'Slug phải là chuỗi ký tự.',
            'slug.max' => 'Slug không được vượt quá 255 ký tự.',
            'slug.unique' => 'Slug đã tồn tại.',
        ];
    }
}
