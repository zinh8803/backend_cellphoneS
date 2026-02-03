<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Storage\StoreStorageRequest;
use App\Http\Requests\Storage\UpdateStorageRequest;
use App\Http\Resources\StorageResource;
use App\Services\StorageService;
use Illuminate\Http\Request;

/**
 * @OA\Tag(
 *     name="Storage",
 *     description="CRUD Storage"
 * )
 */
class StorageController extends Controller
{
    protected StorageService $StorageService;

    public function __construct(StorageService $StorageService)
    {
        $this->StorageService = $StorageService;
    }

    /**
     * @OA\Get(
     *     path="/api/storages",
     *     summary="Danh sách Storage (paging)",
     *     tags={"Storage"},
     *     @OA\Parameter(name="page", in="query", required=false, @OA\Schema(type="integer", example=1)),
     *     @OA\Parameter(name="items_per_page", in="query", required=false, @OA\Schema(type="integer", example=10)),
     *     @OA\Response(
     *         response=200,
     *         description="Danh sách Storage",
     *         @OA\JsonContent(
     *             @OA\Property(property="items", type="array", @OA\Items(ref="#/components/schemas/Storage")),
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
        $result = $this->StorageService->all($request->all());

        return response()->json([
            'items' => StorageResource::collection(collect($result['items'] ?? [])),
            'paginate' => $result['paginate'] ?? null,
        ], 200);
    }

    /**
     * @OA\Get(
     *     path="/api/storages/search",
     *     summary="Tìm kiếm Storage (paging)",
     *     tags={"Storage"},
     *     @OA\Parameter(name="keyword", in="query", required=false, @OA\Schema(type="string")),
     *     @OA\Parameter(name="page", in="query", required=false, @OA\Schema(type="integer", example=1)),
     *     @OA\Parameter(name="items_per_page", in="query", required=false, @OA\Schema(type="integer", example=10)),
     *     @OA\Response(
     *         response=200,
     *         description="Danh sách Storage",
     *         @OA\JsonContent(
     *             @OA\Property(property="items", type="array", @OA\Items(ref="#/components/schemas/Storage")),
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
        $result = $this->StorageService->search($request->all());

        return response()->json([
            'items' => StorageResource::collection(collect($result['items'] ?? [])),
            'paginate' => $result['paginate'] ?? null,
        ], 200);
    }

    /**
     * @OA\Get(
     *     path="/api/storages/{id}",
     *     summary="Chi tiết Storage",
     *     tags={"Storage"},
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer", example=1)),
     *     @OA\Response(response=200, description="Chi tiết Storage", @OA\JsonContent(ref="#/components/schemas/Storage")),
     *     @OA\Response(response=404, description="Không tìm thấy")
     * )
     */
    public function show($id)
    {
        $model = $this->StorageService->show($id);
        if (!$model) {
            return response()->json(['message' => 'Not found'], 404);
        }

        return response()->json(new StorageResource($model), 200);
    }

    /**
     * @OA\Post(
     *     path="/api/storages",
     *     summary="Tạo Storage",
     *     tags={"Storage"},
     *     @OA\RequestBody(required=true, @OA\JsonContent(ref="#/components/schemas/StoreStorageRequest")),
     *     @OA\Response(
     *         response=201,
     *         description="Tạo thành công",
     *         @OA\JsonContent(@OA\Property(property="data", ref="#/components/schemas/Storage"))
     *     )
     * )
     */
    public function store(StoreStorageRequest $request)
    {
        $model = $this->StorageService->store($request->all());
        return response()->json(['data' => new StorageResource($model)], 201);
    }

    /**
     * @OA\Put(
     *     path="/api/storages/{id}",
     *     summary="Cập nhật Storage",
     *     tags={"Storage"},
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer", example=1)),
     *     @OA\RequestBody(required=true, @OA\JsonContent(ref="#/components/schemas/UpdateStorageRequest")),
     *     @OA\Response(
     *         response=200,
     *         description="Cập nhật thành công",
     *         @OA\JsonContent(@OA\Property(property="data", ref="#/components/schemas/Storage"))
     *     ),
     *     @OA\Response(response=404, description="Không tìm thấy")
     * )
     */
    public function update(UpdateStorageRequest $request, $id)
    {
        $model = $this->StorageService->update($id, $request->all());
        if (!$model) {
            return response()->json(['message' => 'Not found'], 404);
        }

        return response()->json(['data' => new StorageResource($model)], 200);
    }

    /**
     * @OA\Delete(
     *     path="/api/storages/{id}",
     *     summary="Xóa Storage",
     *     tags={"Storage"},
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
        $deleted = $this->StorageService->destroy($id);
        return response()->json(['success' => (bool) $deleted], 200);
    }
}