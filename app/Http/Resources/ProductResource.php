<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     schema="Product",
 *     title="Product Resource",
 *     required={"id", "name", "brand_id", "category_id"},
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="name", type="string", example="iPhone 15"),
 *     @OA\Property(property="slug", type="string", example="iphone-15"),
 *     @OA\Property(property="description", type="string", example="..."),
 *     @OA\Property(property="brand_id", type="integer", example=1),
 *     @OA\Property(property="category_id", type="integer", example=1),
 *     @OA\Property(property="brand", ref="#/components/schemas/Brand"),
 *     @OA\Property(property="category", ref="#/components/schemas/Category"),
 *     @OA\Property(property="images", type="array", @OA\Items(ref="#/components/schemas/ProductImage")),
 *     @OA\Property(property="product_attribute_value", type="array", @OA\Items(ref="#/components/schemas/ProductAttributeValue")),
 *     @OA\Property(property="tags", type="array", @OA\Items(ref="#/components/schemas/ProductTag")),
 *     @OA\Property(property="created_at", type="string", format="date-time", example="2025-06-09T10:00:00Z"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", example="2025-06-09T10:00:00Z"),
 * )
 */
class ProductResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'description' => $this->description,
            'brand_id' => $this->brand_id,
            'category_id' => $this->category_id,
            'brand' => $this->whenLoaded('brand', fn() => new BrandResource($this->brand)),
            'category' => $this->whenLoaded('category', fn() => new CategoryResource($this->category)),
            'images' => $this->whenLoaded('productImages', function () {
                return ProductImageResource::collection($this->productImages);
            }),
            'product_attribute_value' => $this->whenLoaded('productAttributeValues', function () {
                return ProductAttributeValueResource::collection($this->productAttributeValues);
            }),

            'tags' => $this->whenLoaded('productTags', function () {
                return ProductTagResource::collection($this->productTags);
            }),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
