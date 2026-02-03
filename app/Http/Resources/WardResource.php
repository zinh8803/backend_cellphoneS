<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     schema="Ward",
 *     type="object",
 *     @OA\Property(property="id", type="integer"),
 *     @OA\Property(property="district_id", type="integer"),
 *     @OA\Property(property="name", type="string"),
 * )
 */
class WardResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'district_id' => $this->district_id,
            'name' => $this->name,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}