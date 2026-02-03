<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\OrderItem\StoreOrderItemRequest;
use App\Http\Requests\OrderItem\UpdateOrderItemRequest;
use App\Http\Resources\OrderItemResource;
use App\Services\OrderItemService;
use Illuminate\Http\Request;

/**
 * @OA\Tag(
 *     name="OrderItem",
 *     description="CRUD OrderItem"
 * )
 */
class OrderItemController extends Controller
{
    protected OrderItemService $OrderItemService;

    public function __construct(OrderItemService $OrderItemService)
    {
        $this->OrderItemService = $OrderItemService;
    }

    /**
     * @OA\Get(
     *     path="/api/order-items",
     *     summary="Danh sách OrderItem (paging)",
     *     tags={"OrderItem"},
     *     @OA\Parameter(name="page", in="query", required=false, @OA\Schema(type="integer", example=1)),
     *     @OA\Parameter(name="items_per_page", in="query", required=false, @OA\Schema(type="integer", example=10)),
     *     @OA\Response(
     *         response=200,
     *         description="Danh sách OrderItem",
     *         @OA\JsonContent(
     *             @OA\Property(property="items", type="array", @OA\Items(ref="#/components/schemas/OrderItem")),
     *             @OA\Property(
     *                 property="paginate",
     *                 type="object",
     *                 @OA\Property(property="current_page", type="integer", example=1),
     *                 @OA\Property(property="per_page", type="integer", example=10),
     *                 @OA\Property(property="total", type="integer", example=100)
     *             )
     *         )
     *     )
     * )
     */
    public function index(Request $request)
    {
        $result = $this->OrderItemService->all($request->all());

        return response()->json([
            'items' => OrderItemResource::collection(collect($result['items'] ?? [])),
            'paginate' => $result['paginate'] ?? null,
        ], 200);
    }

    /**
     * @OA\Get(
     *     path="/api/order-items/search",
     *     summary="Tìm kiếm OrderItem (paging)",
     *     tags={"OrderItem"},
     *     @OA\Parameter(name="keyword", in="query", required=false, @OA\Schema(type="string")),
     *     @OA\Parameter(name="page", in="query", required=false, @OA\Schema(type="integer", example=1)),
     *     @OA\Parameter(name="items_per_page", in="query", required=false, @OA\Schema(type="integer", example=10)),
     *     @OA\Response(
     *         response=200,
     *         description="Danh sách OrderItem",
     *         @OA\JsonContent(
     *             @OA\Property(property="items", type="array", @OA\Items(ref="#/components/schemas/OrderItem")),
     *             @OA\Property(
     *                 property="paginate",
     *                 type="object",
     *                 @OA\Property(property="current_page", type="integer", example=1),
     *                 @OA\Property(property="per_page", type="integer", example=10),
     *                 @OA\Property(property="total", type="integer", example=100)
     *             )
     *         )
     *     )
     * )
     */
    public function search(Request $request)
    {
        $result = $this->OrderItemService->search($request->all());

        return response()->json([
            'items' => OrderItemResource::collection(collect($result['items'] ?? [])),
            'paginate' => $result['paginate'] ?? null,
        ], 200);
    }

    /**
     * @OA\Get(
     *     path="/api/order-items/{id}",
     *     summary="Chi tiết OrderItem",
     *     tags={"OrderItem"},
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer", example=1)),
     *     @OA\Response(response=200, description="Chi tiết OrderItem", @OA\JsonContent(ref="#/components/schemas/OrderItem")),
     *     @OA\Response(response=404, description="Không tìm thấy")
     * )
     */
    public function show($id)
    {
        $model = $this->OrderItemService->show($id);
        if (!$model) {
            return response()->json(['message' => 'Not found'], 404);
        }

        return response()->json(new OrderItemResource($model), 200);
    }

    /**
     * @OA\Post(
     *     path="/api/order-items",
     *     summary="Tạo OrderItem",
     *     tags={"OrderItem"},
     *     @OA\RequestBody(required=true, @OA\JsonContent(ref="#/components/schemas/StoreOrderItemRequest")),
     *     @OA\Response(
     *         response=201,
     *         description="Tạo thành công",
     *         @OA\JsonContent(@OA\Property(property="data", ref="#/components/schemas/OrderItem"))
     *     )
     * )
     */
    public function store(StoreOrderItemRequest $request)
    {
        $model = $this->OrderItemService->store($request->all());
        return response()->json(['data' => new OrderItemResource($model)], 201);
    }

    /**
     * @OA\Put(
     *     path="/api/order-items/{id}",
     *     summary="Cập nhật OrderItem",
     *     tags={"OrderItem"},
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer", example=1)),
     *     @OA\RequestBody(required=true, @OA\JsonContent(ref="#/components/schemas/UpdateOrderItemRequest")),
     *     @OA\Response(
     *         response=200,
     *         description="Cập nhật thành công",
     *         @OA\JsonContent(@OA\Property(property="data", ref="#/components/schemas/OrderItem"))
     *     ),
     *     @OA\Response(response=404, description="Không tìm thấy")
     * )
     */
    public function update(UpdateOrderItemRequest $request, $id)
    {
        $model = $this->OrderItemService->update($id, $request->all());
        if (!$model) {
            return response()->json(['message' => 'Not found'], 404);
        }

        return response()->json(['data' => new OrderItemResource($model)], 200);
    }

    /**
     * @OA\Delete(
     *     path="/api/order-items/{id}",
     *     summary="Xóa OrderItem",
     *     tags={"OrderItem"},
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer", example=1)),
     *     @OA\Response(
     *         response=200,
     *         description="Xóa thành công",
     *         @OA\JsonContent(@OA\Property(property="success", type="boolean", example=true))
     *     )
     * )
     */
    public function destroy($id)
    {
        $deleted = $this->OrderItemService->destroy($id);
        return response()->json(['success' => (bool) $deleted], 200);
    }
}