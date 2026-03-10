<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Cart\AddToCartRequest;
use App\Http\Resources\CartDetailResource;
use App\Services\CartService;

/**
 * @OA\Tag(
 *     name="UserCart",
 *     description="User Cart actions"
 * )
 */
class CartController extends Controller
{
    protected CartService $CartService;

    public function __construct(CartService $CartService)
    {
        $this->CartService = $CartService;
    }

    /**
     * @OA\Post(
     *     path="/api/cart/add",
     *     summary="Thêm sản phẩm vào giỏ hàng (upsert theo branch_product_id)",
     *     tags={"UserCart"},
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(required=true, @OA\JsonContent(ref="#/components/schemas/AddToCartRequest")),
     *     @OA\Response(
     *         response=200,
     *         description="Thành công",
     *         @OA\JsonContent(@OA\Property(property="data", ref="#/components/schemas/CartDetail"))
     *     ),
     *     @OA\Response(response=400, description="Không hợp lệ"),
     *     @OA\Response(response=401, description="Unauthenticated")
     * )
     */
    public function add(AddToCartRequest $request)
    {
        $user = $request->user();
        if (!$user) {
            return response()->json(['message' => 'Unauthenticated'], 401);
        }

        try {
            $detail = $this->CartService->addToCart(
                (int) $user->id,
                (int) $request->input('branch_product_id'),
                (int) $request->input('quantity')
            );

            return response()->json([
                'data' => new CartDetailResource($detail),
            ], 200);
        } catch (\Throwable $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], 400);
        }
    }
}
