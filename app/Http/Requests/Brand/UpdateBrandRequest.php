<?php

namespace App\Http\Requests\Brand;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     schema="UpdateBrandRequest",
 *     @OA\Property(property="name", type="string", example="Apple"),
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
