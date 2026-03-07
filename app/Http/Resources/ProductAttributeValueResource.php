<?php

namespace App\Http\Resources;

use App\Models\Attribute;
use App\Models\ProductAttributeValue;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     schema="ProductAttributeValue",
 *     title="Product Attribute Value",
 *     @OA\Property(property="attribute_id", type="integer", example=1),
 *     @OA\Property(property="name", type="string", example="Color"),
 *     @OA\Property(property="value", type="string", example="Black"),
 *     @OA\Property(property="product_id", type="integer", example=1)
 * )
 */
class ProductAttributeValueResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'attribute_id' => $this->attribute_id,
            'product_id' => $this->product_id,
            'value' => $this->value,
            'name' => $this->whenLoaded('attribute', fn() => $this->attribute?->name),
        ];
    }
}
