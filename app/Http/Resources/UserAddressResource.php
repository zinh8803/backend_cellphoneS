<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     schema="UserAddress",
 *     type="object",
 *     @OA\Property(property="id", type="integer"),
 *     @OA\Property(property="user_id", type="integer"),
 *     @OA\Property(property="city_id", type="integer"),
 *     @OA\Property(property="ward_id", type="integer"),
 *     @OA\Property(property="detail", type="string"),
 *     @OA\Property(property="receiver_name", type="string"),
 *     @OA\Property(property="phone", type="string"),
 *     @OA\Property(property="is_default", type="boolean"),
 *     @OA\Property(property="created_at", type="string"),
 * )
 */
class UserAddressResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'city_id' => $this->city_id,
            'ward_id' => $this->ward_id,
            'detail' => $this->detail,
            'receiver_name' => $this->receiver_name,
            'phone' => $this->phone,
            'is_default' => $this->is_default,
            'created_at' => $this->created_at,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}