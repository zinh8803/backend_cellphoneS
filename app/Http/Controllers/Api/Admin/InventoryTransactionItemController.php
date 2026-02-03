<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\InventoryTransactionItem\StoreInventoryTransactionItemRequest;
use App\Http\Requests\InventoryTransactionItem\UpdateInventoryTransactionItemRequest;
use App\Http\Resources\InventoryTransactionItemResource;
use App\Services\InventoryTransactionItemService;
use Illuminate\Http\Request;

/**
 * @OA\Tag(
 *     name="InventoryTransactionItem",
 *     description="CRUD InventoryTransactionItem"
 * )
 */
class InventoryTransactionItemController extends Controller
{
    protected InventoryTransactionItemService $InventoryTransactionItemService;

    public function __construct(InventoryTransactionItemService $InventoryTransactionItemService)
    {
        $this->InventoryTransactionItemService = $InventoryTransactionItemService;
    }

    /**
     * @OA\Get(
     *     path="/api/inventory-transaction-items",
     *     summary="Danh sách InventoryTransactionItem (paging)",
     *     tags={"InventoryTransactionItem"},
     *     @OA\Parameter(name="page", in="query", required=false, @OA\Schema(type="integer", example=1)),
     *     @OA\Parameter(name="items_per_page", in="query", required=false, @OA\Schema(type="integer", example=10)),
     *     @OA\Response(
     *         response=200,
     *         description="Danh sách InventoryTransactionItem",
     *         @OA\JsonContent(
     *             @OA\Property(property="items", type="array", @OA\Items(ref="#/components/schemas/InventoryTransactionItem")),
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
        $result = $this->InventoryTransactionItemService->all($request->all());

        return response()->json([
            'items' => InventoryTransactionItemResource::collection(collect($result['items'] ?? [])),
            'paginate' => $result['paginate'] ?? null,
        ], 200);
    }

    /**
     * @OA\Get(
     *     path="/api/inventory-transaction-items/search",
     *     summary="Tìm kiếm InventoryTransactionItem (paging)",
     *     tags={"InventoryTransactionItem"},
     *     @OA\Parameter(name="keyword", in="query", required=false, @OA\Schema(type="string")),
     *     @OA\Parameter(name="page", in="query", required=false, @OA\Schema(type="integer", example=1)),
     *     @OA\Parameter(name="items_per_page", in="query", required=false, @OA\Schema(type="integer", example=10)),
     *     @OA\Response(
     *         response=200,
     *         description="Danh sách InventoryTransactionItem",
     *         @OA\JsonContent(
     *             @OA\Property(property="items", type="array", @OA\Items(ref="#/components/schemas/InventoryTransactionItem")),
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
        $result = $this->InventoryTransactionItemService->search($request->all());

        return response()->json([
            'items' => InventoryTransactionItemResource::collection(collect($result['items'] ?? [])),
            'paginate' => $result['paginate'] ?? null,
        ], 200);
    }

    /**
     * @OA\Get(
     *     path="/api/inventory-transaction-items/{id}",
     *     summary="Chi tiết InventoryTransactionItem",
     *     tags={"InventoryTransactionItem"},
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer", example=1)),
     *     @OA\Response(response=200, description="Chi tiết InventoryTransactionItem", @OA\JsonContent(ref="#/components/schemas/InventoryTransactionItem")),
     *     @OA\Response(response=404, description="Không tìm thấy")
     * )
     */
    public function show($id)
    {
        $model = $this->InventoryTransactionItemService->show($id);
        if (!$model) {
            return response()->json(['message' => 'Not found'], 404);
        }

        return response()->json(new InventoryTransactionItemResource($model), 200);
    }

    /**
     * @OA\Post(
     *     path="/api/inventory-transaction-items",
     *     summary="Tạo InventoryTransactionItem",
     *     tags={"InventoryTransactionItem"},
     *     @OA\RequestBody(required=true, @OA\JsonContent(ref="#/components/schemas/StoreInventoryTransactionItemRequest")),
     *     @OA\Response(
     *         response=201,
     *         description="Tạo thành công",
     *         @OA\JsonContent(@OA\Property(property="data", ref="#/components/schemas/InventoryTransactionItem"))
     *     )
     * )
     */
    public function store(StoreInventoryTransactionItemRequest $request)
    {
        $model = $this->InventoryTransactionItemService->store($request->all());
        return response()->json(['data' => new InventoryTransactionItemResource($model)], 201);
    }

    /**
     * @OA\Put(
     *     path="/api/inventory-transaction-items/{id}",
     *     summary="Cập nhật InventoryTransactionItem",
     *     tags={"InventoryTransactionItem"},
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer", example=1)),
     *     @OA\RequestBody(required=true, @OA\JsonContent(ref="#/components/schemas/UpdateInventoryTransactionItemRequest")),
     *     @OA\Response(
     *         response=200,
     *         description="Cập nhật thành công",
     *         @OA\JsonContent(@OA\Property(property="data", ref="#/components/schemas/InventoryTransactionItem"))
     *     ),
     *     @OA\Response(response=404, description="Không tìm thấy")
     * )
     */
    public function update(UpdateInventoryTransactionItemRequest $request, $id)
    {
        $model = $this->InventoryTransactionItemService->update($id, $request->all());
        if (!$model) {
            return response()->json(['message' => 'Not found'], 404);
        }

        return response()->json(['data' => new InventoryTransactionItemResource($model)], 200);
    }

    /**
     * @OA\Delete(
     *     path="/api/inventory-transaction-items/{id}",
     *     summary="Xóa InventoryTransactionItem",
     *     tags={"InventoryTransactionItem"},
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
        $deleted = $this->InventoryTransactionItemService->destroy($id);
        return response()->json(['success' => (bool) $deleted], 200);
    }
}