<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\InventoryTransaction\StoreInventoryTransactionRequest;
use App\Http\Requests\InventoryTransaction\UpdateInventoryTransactionRequest;
use App\Http\Resources\InventoryTransactionResource;
use App\Services\InventoryTransactionService;
use Illuminate\Http\Request;

/**
 * @OA\Tag(
 *     name="InventoryTransaction",
 *     description="CRUD InventoryTransaction"
 * )
 */
class InventoryTransactionController extends Controller
{
    protected InventoryTransactionService $InventoryTransactionService;

    public function __construct(InventoryTransactionService $InventoryTransactionService)
    {
        $this->InventoryTransactionService = $InventoryTransactionService;
    }

    /**
     * @OA\Get(
     *     path="/api/inventory-transactions",
     *     summary="Danh sách InventoryTransaction (paging)",
     *     tags={"InventoryTransaction"},
     *     @OA\Parameter(name="page", in="query", required=false, @OA\Schema(type="integer", example=1)),
     *     @OA\Parameter(name="items_per_page", in="query", required=false, @OA\Schema(type="integer", example=10)),
     *     @OA\Response(
     *         response=200,
     *         description="Danh sách InventoryTransaction",
     *         @OA\JsonContent(
     *             @OA\Property(property="items", type="array", @OA\Items(ref="#/components/schemas/InventoryTransaction")),
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
        $result = $this->InventoryTransactionService->all($request->all());

        return response()->json([
            'items' => InventoryTransactionResource::collection(collect($result['items'] ?? [])),
            'paginate' => $result['paginate'] ?? null,
        ], 200);
    }

    /**
     * @OA\Get(
     *     path="/api/inventory-transactions/search",
     *     summary="Tìm kiếm InventoryTransaction (paging)",
     *     tags={"InventoryTransaction"},
     *     @OA\Parameter(name="keyword", in="query", required=false, @OA\Schema(type="string")),
     *     @OA\Parameter(name="page", in="query", required=false, @OA\Schema(type="integer", example=1)),
     *     @OA\Parameter(name="items_per_page", in="query", required=false, @OA\Schema(type="integer", example=10)),
     *     @OA\Response(
     *         response=200,
     *         description="Danh sách InventoryTransaction",
     *         @OA\JsonContent(
     *             @OA\Property(property="items", type="array", @OA\Items(ref="#/components/schemas/InventoryTransaction")),
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
        $result = $this->InventoryTransactionService->search($request->all());

        return response()->json([
            'items' => InventoryTransactionResource::collection(collect($result['items'] ?? [])),
            'paginate' => $result['paginate'] ?? null,
        ], 200);
    }

    /**
     * @OA\Get(
     *     path="/api/inventory-transactions/{id}",
     *     summary="Chi tiết InventoryTransaction",
     *     tags={"InventoryTransaction"},
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer", example=1)),
     *     @OA\Response(response=200, description="Chi tiết InventoryTransaction", @OA\JsonContent(ref="#/components/schemas/InventoryTransaction")),
     *     @OA\Response(response=404, description="Không tìm thấy")
     * )
     */
    public function show($id)
    {
        $model = $this->InventoryTransactionService->show($id);
        if (!$model) {
            return response()->json(['message' => 'Not found'], 404);
        }

        return response()->json(new InventoryTransactionResource($model), 200);
    }

    /**
     * @OA\Post(
     *     path="/api/inventory-transactions",
     *     summary="Tạo InventoryTransaction",
     *     tags={"InventoryTransaction"},
     *     @OA\RequestBody(required=true, @OA\JsonContent(ref="#/components/schemas/StoreInventoryTransactionRequest")),
     *     @OA\Response(
     *         response=201,
     *         description="Tạo thành công",
     *         @OA\JsonContent(@OA\Property(property="data", ref="#/components/schemas/InventoryTransaction"))
     *     )
     * )
     */
    public function store(StoreInventoryTransactionRequest $request)
    {
        $model = $this->InventoryTransactionService->store($request->all());
        return response()->json(['data' => new InventoryTransactionResource($model)], 201);
    }

    /**
     * @OA\Put(
     *     path="/api/inventory-transactions/{id}",
     *     summary="Cập nhật InventoryTransaction",
     *     tags={"InventoryTransaction"},
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer", example=1)),
     *     @OA\RequestBody(required=true, @OA\JsonContent(ref="#/components/schemas/UpdateInventoryTransactionRequest")),
     *     @OA\Response(
     *         response=200,
     *         description="Cập nhật thành công",
     *         @OA\JsonContent(@OA\Property(property="data", ref="#/components/schemas/InventoryTransaction"))
     *     ),
     *     @OA\Response(response=404, description="Không tìm thấy")
     * )
     */
    public function update(UpdateInventoryTransactionRequest $request, $id)
    {
        $model = $this->InventoryTransactionService->update($id, $request->all());
        if (!$model) {
            return response()->json(['message' => 'Not found'], 404);
        }

        return response()->json(['data' => new InventoryTransactionResource($model)], 200);
    }

    /**
     * @OA\Delete(
     *     path="/api/inventory-transactions/{id}",
     *     summary="Xóa InventoryTransaction",
     *     tags={"InventoryTransaction"},
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
        $deleted = $this->InventoryTransactionService->destroy($id);
        return response()->json(['success' => (bool) $deleted], 200);
    }
}