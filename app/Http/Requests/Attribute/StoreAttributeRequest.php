<?php

namespace App\Http\Requests\Attribute;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     schema="StoreAttributeRequest",
 *     required={"name"},
 *     @OA\Property(property="name", type="string", example="Color"),
 * )
 */
class StoreAttributeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255|unique:attributes,name',
        ];
    }
}
