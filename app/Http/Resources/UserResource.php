<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     schema="User",
 *     title="User Resource",
 *     required={"id", "name", "email"},
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="uuid", type="string", example="123e4567-e89b-12d3-a456-426614174000"),
 *     @OA\Property(property="name", type="string", example="Nguyen Van A"),
 *     @OA\Property(property="email", type="string", format="email", example="a@example.com"),
 *     @OA\Property(property="role_id", type="integer", example=2),
 *     @OA\Property(property="image_url", type="string", format="uri", example="http://localhost/storage/avatar.jpg"),
 *     @OA\Property(property="created_at", type="string", format="date-time", example="2025-06-09T10:00:00Z"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", example="2025-06-09T10:00:00Z"),
 * )
 */
class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'uuid' => $this->uuid,
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'gender' => $this->gender,
            'status' => $this->status,
            'image_url' => $this->image_url,
            'role' => new RoleResource($this->role),
            'employee' => new EmployeeResource($this->employee),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
