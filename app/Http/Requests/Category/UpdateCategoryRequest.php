<?php

namespace App\Http\Requests\Category;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     schema="UpdateCategoryRequest",
 *     @OA\Property(property="name", type="string", example="Phone"),
 *     @OA\Property(property="slug", type="string", example="phone"),
 * )
 */
class UpdateCategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = $this->route('id');

        return [
            'name' => 'sometimes|required|string|max:255|unique:categories,name,' . $id,
            'slug' => 'sometimes|required|string|max:255|unique:categories,slug,' . $id,
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Tên category là bắt buộc.',
            'name.string' => 'Tên category phải là chuỗi ký tự.',
            'name.max' => 'Tên category không được vượt quá 255 ký tự.',
            'name.unique' => 'Tên category đã tồn tại.',
            'slug.required' => 'Slug là bắt buộc.',
            'slug.string' => 'Slug phải là chuỗi ký tự.',
            'slug.max' => 'Slug không được vượt quá 255 ký tự.',
            'slug.unique' => 'Slug đã tồn tại.',
        ];
    }
}
