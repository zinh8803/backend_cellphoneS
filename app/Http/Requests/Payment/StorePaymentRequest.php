<?php

namespace App\Http\Requests\Payment;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     schema="StorePaymentRequest",
 *     type="object",
 *     @OA\Property(property="order_id", type="integer"),
 *     @OA\Property(property="method", type="string"),
 *     @OA\Property(property="status", type="string"),
 *     @OA\Property(property="paid_at", type="string"),
 * )
 */
class StorePaymentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'order_id' => 'sometimes|integer',
            'method' => 'sometimes|nullable|string',
            'status' => 'sometimes|nullable|string',
            'paid_at' => 'sometimes|nullable|string',
        ];
    }
}