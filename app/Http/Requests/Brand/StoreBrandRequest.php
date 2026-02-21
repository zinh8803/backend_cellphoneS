<?php

namespace App\Http\Requests\Brand;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     schema="StoreBrandRequest",
 *     required={"name", "slug"},
 *     @OA\Property(property="name", type="string", example="Apple"),
 * )
 */
class StoreBrandRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255|unique:brands,name',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Tên brand là bắt buộc.',
            'name.string' => 'Tên brand phải là chuỗi ký tự.',
            'name.max' => 'Tên brand không được vượt quá 255 ký tự.',
            'name.unique' => 'Tên brand đã tồn tại.',
        ];
    }
}
