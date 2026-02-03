<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     schema="ProductTag",
 *     title="ProductTag Resource",
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="tag", ref="#/components/schemas/Tag"),
 * )
 */
class ProductTagResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'tag' => $this->whenLoaded('tag', function () {
                return new TagResource($this->tag);
            }),
        ];
    }
}
