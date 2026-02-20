<?php

namespace App\Http\Requests\Category;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     schema="StoreCategoryRequest",
 *     required={"name", "slug"},
 *     @OA\Property(property="name", type="string", example="Phone"),
 * )
 */
class StoreCategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255|unique:categories,name',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Tên category là bắt buộc.',
            'name.string' => 'Tên category phải là chuỗi ký tự.',
            'name.max' => 'Tên category không được vượt quá 255 ký tự.',
            'name.unique' => 'Tên category đã tồn tại.',
        ];
    }
}
