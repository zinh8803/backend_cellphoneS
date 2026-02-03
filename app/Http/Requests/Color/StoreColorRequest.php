<?php

namespace App\Http\Requests\Color;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     schema="StoreColorRequest",
 *     required={"name", "code"},
 *     @OA\Property(property="name", type="string", example="Red"),
 *     @OA\Property(property="code", type="string", example="#FF0000"),
 * )
 */
class StoreColorRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255|unique:colors,name',
            'code' => 'required|string|max:50|unique:colors,code',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Tên màu là bắt buộc.',
            'name.string' => 'Tên màu phải là chuỗi ký tự.',
            'name.max' => 'Tên màu không được vượt quá 255 ký tự.',
            'name.unique' => 'Tên màu đã tồn tại.',
            'code.required' => 'Mã màu là bắt buộc.',
            'code.string' => 'Mã màu phải là chuỗi ký tự.',
            'code.max' => 'Mã màu không được vượt quá 50 ký tự.',
            'code.unique' => 'Mã màu đã tồn tại.',
        ];
    }
}
