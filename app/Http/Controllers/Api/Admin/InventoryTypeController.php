<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\InventoryType\StoreInventoryTypeRequest;
use App\Http\Requests\InventoryType\UpdateInventoryTypeRequest;
use App\Http\Resources\InventoryTypeResource;
use App\Services\InventoryTypeService;
use Illuminate\Http\Request;

/**
 * @OA\Tag(
 *     name="InventoryType",
 *     description="CRUD InventoryType"
 * )
 */
class InventoryTypeController extends Controller
{
    protected InventoryTypeService $InventoryTypeService;

    public function __construct(InventoryTypeService $InventoryTypeService)
    {
        $this->InventoryTypeService = $InventoryTypeService;
    }

    /**
     * @OA\Get(
     *     path="/api/inventory-types",
     *     summary="Danh sách InventoryType (paging)",
     *     tags={"InventoryType"},
     *     @OA\Parameter(name="page", in="query", required=false, @OA\Schema(type="integer", example=1)),
     *     @OA\Parameter(name="items_per_page", in="query", required=false, @OA\Schema(type="integer", example=10)),
     *     @OA\Response(
     *         response=200,
     *         description="Danh sách InventoryType",
     *         @OA\JsonContent(
     *             @OA\Property(property="items", type="array", @OA\Items(ref="#/components/schemas/InventoryType")),
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
        $result = $this->InventoryTypeService->all($request->all());

        return response()->json([
            'items' => InventoryTypeResource::collection(collect($result['items'] ?? [])),
            'paginate' => $result['paginate'] ?? null,
        ], 200);
    }

    /**
     * @OA\Get(
     *     path="/api/inventory-types/search",
     *     summary="Tìm kiếm InventoryType (paging)",
     *     tags={"InventoryType"},
     *     @OA\Parameter(name="keyword", in="query", required=false, @OA\Schema(type="string")),
     *     @OA\Parameter(name="page", in="query", required=false, @OA\Schema(type="integer", example=1)),
     *     @OA\Parameter(name="items_per_page", in="query", required=false, @OA\Schema(type="integer", example=10)),
     *     @OA\Response(
     *         response=200,
     *         description="Danh sách InventoryType",
     *         @OA\JsonContent(
     *             @OA\Property(property="items", type="array", @OA\Items(ref="#/components/schemas/InventoryType")),
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
        $result = $this->InventoryTypeService->search($request->all());

        return response()->json([
            'items' => InventoryTypeResource::collection(collect($result['items'] ?? [])),
            'paginate' => $result['paginate'] ?? null,
        ], 200);
    }

    /**
     * @OA\Get(
     *     path="/api/inventory-types/{id}",
     *     summary="Chi tiết InventoryType",
     *     tags={"InventoryType"},
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer", example=1)),
     *     @OA\Response(response=200, description="Chi tiết InventoryType", @OA\JsonContent(ref="#/components/schemas/InventoryType")),
     *     @OA\Response(response=404, description="Không tìm thấy")
     * )
     */
    public function show($id)
    {
        $model = $this->InventoryTypeService->show($id);
        if (!$model) {
            return response()->json(['message' => 'Not found'], 404);
        }

        return response()->json(new InventoryTypeResource($model), 200);
    }

    /**
     * @OA\Post(
     *     path="/api/inventory-types",
     *     summary="Tạo InventoryType",
     *     tags={"InventoryType"},
     *     @OA\RequestBody(required=true, @OA\JsonContent(ref="#/components/schemas/StoreInventoryTypeRequest")),
     *     @OA\Response(
     *         response=201,
     *         description="Tạo thành công",
     *         @OA\JsonContent(@OA\Property(property="data", ref="#/components/schemas/InventoryType"))
     *     )
     * )
     */
    public function store(StoreInventoryTypeRequest $request)
    {
        $model = $this->InventoryTypeService->store($request->all());
        return response()->json(['data' => new InventoryTypeResource($model)], 201);
    }

    /**
     * @OA\Put(
     *     path="/api/inventory-types/{id}",
     *     summary="Cập nhật InventoryType",
     *     tags={"InventoryType"},
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer", example=1)),
     *     @OA\RequestBody(required=true, @OA\JsonContent(ref="#/components/schemas/UpdateInventoryTypeRequest")),
     *     @OA\Response(
     *         response=200,
     *         description="Cập nhật thành công",
     *         @OA\JsonContent(@OA\Property(property="data", ref="#/components/schemas/InventoryType"))
     *     ),
     *     @OA\Response(response=404, description="Không tìm thấy")
     * )
     */
    public function update(UpdateInventoryTypeRequest $request, $id)
    {
        $model = $this->InventoryTypeService->update($id, $request->all());
        if (!$model) {
            return response()->json(['message' => 'Not found'], 404);
        }

        return response()->json(['data' => new InventoryTypeResource($model)], 200);
    }

    /**
     * @OA\Delete(
     *     path="/api/inventory-types/{id}",
     *     summary="Xóa InventoryType",
     *     tags={"InventoryType"},
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
        $deleted = $this->InventoryTypeService->destroy($id);
        return response()->json(['success' => (bool) $deleted], 200);
    }
}