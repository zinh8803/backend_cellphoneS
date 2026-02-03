<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     schema="ProductImage",
 *     title="ProductImage Resource",
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="image", ref="#/components/schemas/Image"),
 *     @OA\Property(property="is_primary", type="boolean", example=true),
 * )
 */
class ProductImageResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'image' => $this->whenLoaded('image', function () {
                return new ImageResource($this->image);
            }),
            'is_primary' => (bool) $this->is_primary,
        ];
    }
}
