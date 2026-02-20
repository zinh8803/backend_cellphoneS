<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * @OA\Schema(
 *     schema="StoreProductRequest",
 *     required={"name","brand_id","category_id"},
 *     @OA\Property(property="name", type="string", example="iPhone 15", description="Tên sản phẩm"),
 *     @OA\Property(property="slug", type="string", example="iphone-15", description="Slug sản phẩm"),
 *     @OA\Property(property="description", type="string", example="...", description="Mô tả sản phẩm"),
 *     @OA\Property(property="brand_id", type="integer", example=1, description="ID thương hiệu"),
 *     @OA\Property(property="category_id", type="integer", example=1, description="ID danh mục"),
 *     @OA\Property(
 *         property="tag_ids[]",
 *         type="array",
 *         description="Danh sách tag id (key lặp: tag_ids[])",
 *         @OA\Items(type="integer"),
 *         example={1,2}
 *     ),
 *     @OA\Property(
 *         property="image_files[]",
 *         type="array",
 *         description="Danh sách ảnh upload (key lặp: image_files[])",
 *         @OA\Items(type="string", format="binary")
 *     )
 * )
 */
class StoreProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'brand_id' => 'required|integer|exists:brands,id',
            'category_id' => 'required|integer|exists:categories,id',
            'tag_ids' => 'sometimes|nullable|array',
            'tag_ids.*' => 'nullable|integer|exists:tags,id',
            'image_files' => [
                'sometimes',
                function ($attribute, $value, $fail) {
                    if ($value instanceof UploadedFile) {
                        if (!$value->isValid()) {
                            $fail('File ảnh không hợp lệ.');
                        }
                        return;
                    }

                    if (is_array($value)) {
                        foreach ($value as $file) {
                            if (!$file instanceof UploadedFile || !$file->isValid()) {
                                $fail('Mỗi phần tử image_files phải là file ảnh hợp lệ.');
                                return;
                            }
                        }
                        return;
                    }

                    $fail('image_files phải là file hoặc mảng file ảnh.');
                },
            ],
            'image_files.*' => 'image|max:5120',
        ];
    }
}
