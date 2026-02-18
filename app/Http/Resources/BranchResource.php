<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     schema="Branch",
 *     type="object",
 *     @OA\Property(property="id", type="integer"),
 *     @OA\Property(property="name", type="string"),
 *     @OA\Property(property="detail", type="string"),
 *    @OA\Property(property="city", ref="#/components/schemas/City"),
 *   @OA\Property(property="ward", ref="#/components/schemas/Ward"),
 * )
 */
class BranchResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'detail' => $this->detail,
            'city' => new CityResource($this->city),
            'ward' => new WardResource($this->ward),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
