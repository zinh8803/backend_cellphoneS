<?php

namespace App\Http\Requests\Category;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     schema="UpdateCategoryRequest",
 *     @OA\Property(property="name", type="string", example="Phone"),
 *     @OA\Property(property="parent_id", type="integer", example=1, nullable=true)
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
            'parent_id' => 'nullable|exists:categories,id',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Tên category là bắt buộc.',
            'name.string' => 'Tên category phải là chuỗi ký tự.',
            'name.max' => 'Tên category không được vượt quá 255 ký tự.',
            'name.unique' => 'Tên category đã tồn tại.',
            'parent_id.exists' => 'Parent ID không tồn tại trong bảng categories.',
        ];
    }
}
