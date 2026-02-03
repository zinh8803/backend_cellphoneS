<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\RefreshToken\StoreRefreshTokenRequest;
use App\Http\Requests\RefreshToken\UpdateRefreshTokenRequest;
use App\Http\Resources\RefreshTokenResource;
use App\Services\RefreshTokenService;
use Illuminate\Http\Request;

/**
 * @OA\Tag(
 *     name="RefreshToken",
 *     description="CRUD RefreshToken"
 * )
 */
class RefreshTokenController extends Controller
{
    protected RefreshTokenService $RefreshTokenService;

    public function __construct(RefreshTokenService $RefreshTokenService)
    {
        $this->RefreshTokenService = $RefreshTokenService;
    }

    /**
     * @OA\Get(
     *     path="/api/refresh-tokens",
     *     summary="Danh sách RefreshToken (paging)",
     *     tags={"RefreshToken"},
     *     @OA\Parameter(name="page", in="query", required=false, @OA\Schema(type="integer", example=1)),
     *     @OA\Parameter(name="items_per_page", in="query", required=false, @OA\Schema(type="integer", example=10)),
     *     @OA\Response(
     *         response=200,
     *         description="Danh sách RefreshToken",
     *         @OA\JsonContent(
     *             @OA\Property(property="items", type="array", @OA\Items(ref="#/components/schemas/RefreshToken")),
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
        $result = $this->RefreshTokenService->all($request->all());

        return response()->json([
            'items' => RefreshTokenResource::collection(collect($result['items'] ?? [])),
            'paginate' => $result['paginate'] ?? null,
        ], 200);
    }

    /**
     * @OA\Get(
     *     path="/api/refresh-tokens/search",
     *     summary="Tìm kiếm RefreshToken (paging)",
     *     tags={"RefreshToken"},
     *     @OA\Parameter(name="keyword", in="query", required=false, @OA\Schema(type="string")),
     *     @OA\Parameter(name="page", in="query", required=false, @OA\Schema(type="integer", example=1)),
     *     @OA\Parameter(name="items_per_page", in="query", required=false, @OA\Schema(type="integer", example=10)),
     *     @OA\Response(
     *         response=200,
     *         description="Danh sách RefreshToken",
     *         @OA\JsonContent(
     *             @OA\Property(property="items", type="array", @OA\Items(ref="#/components/schemas/RefreshToken")),
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
        $result = $this->RefreshTokenService->search($request->all());

        return response()->json([
            'items' => RefreshTokenResource::collection(collect($result['items'] ?? [])),
            'paginate' => $result['paginate'] ?? null,
        ], 200);
    }

    /**
     * @OA\Get(
     *     path="/api/refresh-tokens/{id}",
     *     summary="Chi tiết RefreshToken",
     *     tags={"RefreshToken"},
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer", example=1)),
     *     @OA\Response(response=200, description="Chi tiết RefreshToken", @OA\JsonContent(ref="#/components/schemas/RefreshToken")),
     *     @OA\Response(response=404, description="Không tìm thấy")
     * )
     */
    public function show($id)
    {
        $model = $this->RefreshTokenService->show($id);
        if (!$model) {
            return response()->json(['message' => 'Not found'], 404);
        }

        return response()->json(new RefreshTokenResource($model), 200);
    }

    /**
     * @OA\Post(
     *     path="/api/refresh-tokens",
     *     summary="Tạo RefreshToken",
     *     tags={"RefreshToken"},
     *     @OA\RequestBody(required=true, @OA\JsonContent(ref="#/components/schemas/StoreRefreshTokenRequest")),
     *     @OA\Response(
     *         response=201,
     *         description="Tạo thành công",
     *         @OA\JsonContent(@OA\Property(property="data", ref="#/components/schemas/RefreshToken"))
     *     )
     * )
     */
    public function store(StoreRefreshTokenRequest $request)
    {
        $model = $this->RefreshTokenService->store($request->all());
        return response()->json(['data' => new RefreshTokenResource($model)], 201);
    }

    /**
     * @OA\Put(
     *     path="/api/refresh-tokens/{id}",
     *     summary="Cập nhật RefreshToken",
     *     tags={"RefreshToken"},
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer", example=1)),
     *     @OA\RequestBody(required=true, @OA\JsonContent(ref="#/components/schemas/UpdateRefreshTokenRequest")),
     *     @OA\Response(
     *         response=200,
     *         description="Cập nhật thành công",
     *         @OA\JsonContent(@OA\Property(property="data", ref="#/components/schemas/RefreshToken"))
     *     ),
     *     @OA\Response(response=404, description="Không tìm thấy")
     * )
     */
    public function update(UpdateRefreshTokenRequest $request, $id)
    {
        $model = $this->RefreshTokenService->update($id, $request->all());
        if (!$model) {
            return response()->json(['message' => 'Not found'], 404);
        }

        return response()->json(['data' => new RefreshTokenResource($model)], 200);
    }

    /**
     * @OA\Delete(
     *     path="/api/refresh-tokens/{id}",
     *     summary="Xóa RefreshToken",
     *     tags={"RefreshToken"},
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
        $deleted = $this->RefreshTokenService->destroy($id);
        return response()->json(['success' => (bool) $deleted], 200);
    }
}