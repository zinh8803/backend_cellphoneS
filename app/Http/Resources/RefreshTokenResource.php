<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     schema="RefreshToken",
 *     type="object",
 *     @OA\Property(property="id", type="integer"),
 *     @OA\Property(property="token", type="string"),
 *     @OA\Property(property="user_id", type="integer"),
 *     @OA\Property(property="expires_at", type="string"),
 *     @OA\Property(property="ip_address", type="string"),
 *     @OA\Property(property="user_agent", type="string"),
 * )
 */
class RefreshTokenResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'token' => $this->token,
            'user_id' => $this->user_id,
            'expires_at' => $this->expires_at,
            'ip_address' => $this->ip_address,
            'user_agent' => $this->user_agent,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}