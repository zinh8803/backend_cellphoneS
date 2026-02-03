<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     schema="InventoryTransaction",
 *     type="object",
 *     @OA\Property(property="id", type="integer"),
 *     @OA\Property(property="branch_id", type="integer"),
 *     @OA\Property(property="type_id", type="integer"),
 *     @OA\Property(property="code", type="string"),
 *     @OA\Property(property="note", type="string"),
 *     @OA\Property(property="created_by", type="string"),
 *     @OA\Property(property="created_at", type="string"),
 * )
 */
class InventoryTransactionResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'branch_id' => $this->branch_id,
            'type_id' => $this->type_id,
            'code' => $this->code,
            'note' => $this->note,
            'created_by' => $this->created_by,
            'created_at' => $this->created_at,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}