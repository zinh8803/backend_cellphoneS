<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Ward\StoreWardRequest;
use App\Http\Requests\Ward\UpdateWardRequest;
use App\Http\Resources\WardResource;
use App\Services\WardService;
use Illuminate\Http\Request;

/**
 * @OA\Tag(
 *     name="Ward",
 *     description="CRUD Ward"
 * )
 */
class WardController extends Controller
{
    protected WardService $WardService;

    public function __construct(WardService $WardService)
    {
        $this->WardService = $WardService;
    }

    /**
     * @OA\Get(
     *     path="/api/wards",
     *     summary="Danh sách Ward (paging)",
     *     tags={"Ward"},
     *     @OA\Parameter(name="page", in="query", required=false, @OA\Schema(type="integer", example=1)),
     *     @OA\Parameter(name="items_per_page", in="query", required=false, @OA\Schema(type="integer", example=10)),
     *     @OA\Response(
     *         response=200,
     *         description="Danh sách Ward",
     *         @OA\JsonContent(
     *             @OA\Property(property="items", type="array", @OA\Items(ref="#/components/schemas/Ward")),
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
        $result = $this->WardService->all($request->all());

        return response()->json([
            'items' => WardResource::collection(collect($result['items'] ?? [])),
            'paginate' => $result['paginate'] ?? null,
        ], 200);
    }

    /**
     * @OA\Get(
     *     path="/api/wards/search",
     *     summary="Tìm kiếm Ward (paging)",
     *     tags={"Ward"},
     *     @OA\Parameter(name="keyword", in="query", required=false, @OA\Schema(type="string")),
     *     @OA\Parameter(name="page", in="query", required=false, @OA\Schema(type="integer", example=1)),
     *     @OA\Parameter(name="items_per_page", in="query", required=false, @OA\Schema(type="integer", example=10)),
     *     @OA\Response(
     *         response=200,
     *         description="Danh sách Ward",
     *         @OA\JsonContent(
     *             @OA\Property(property="items", type="array", @OA\Items(ref="#/components/schemas/Ward")),
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
        $result = $this->WardService->search($request->all());

        return response()->json([
            'items' => WardResource::collection(collect($result['items'] ?? [])),
            'paginate' => $result['paginate'] ?? null,
        ], 200);
    }

    /**
     * @OA\Get(
     *     path="/api/wards/{id}",
     *     summary="Chi tiết Ward",
     *     tags={"Ward"},
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer", example=1)),
     *     @OA\Response(response=200, description="Chi tiết Ward", @OA\JsonContent(ref="#/components/schemas/Ward")),
     *     @OA\Response(response=404, description="Không tìm thấy")
     * )
     */
    public function show($id)
    {
        $model = $this->WardService->show($id);
        if (!$model) {
            return response()->json(['message' => 'Not found'], 404);
        }

        return response()->json(new WardResource($model), 200);
    }

    /**
     * @OA\Post(
     *     path="/api/wards",
     *     summary="Tạo Ward",
     *     tags={"Ward"},
     *     @OA\RequestBody(required=true, @OA\JsonContent(ref="#/components/schemas/StoreWardRequest")),
     *     @OA\Response(
     *         response=201,
     *         description="Tạo thành công",
     *         @OA\JsonContent(@OA\Property(property="data", ref="#/components/schemas/Ward"))
     *     )
     * )
     */
    public function store(StoreWardRequest $request)
    {
        $model = $this->WardService->store($request->all());
        return response()->json(['data' => new WardResource($model)], 201);
    }

    /**
     * @OA\Put(
     *     path="/api/wards/{id}",
     *     summary="Cập nhật Ward",
     *     tags={"Ward"},
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer", example=1)),
     *     @OA\RequestBody(required=true, @OA\JsonContent(ref="#/components/schemas/UpdateWardRequest")),
     *     @OA\Response(
     *         response=200,
     *         description="Cập nhật thành công",
     *         @OA\JsonContent(@OA\Property(property="data", ref="#/components/schemas/Ward"))
     *     ),
     *     @OA\Response(response=404, description="Không tìm thấy")
     * )
     */
    public function update(UpdateWardRequest $request, $id)
    {
        $model = $this->WardService->update($id, $request->all());
        if (!$model) {
            return response()->json(['message' => 'Not found'], 404);
        }

        return response()->json(['data' => new WardResource($model)], 200);
    }

    /**
     * @OA\Delete(
     *     path="/api/wards/{id}",
     *     summary="Xóa Ward",
     *     tags={"Ward"},
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
        $deleted = $this->WardService->destroy($id);
        return response()->json(['success' => (bool) $deleted], 200);
    }
}