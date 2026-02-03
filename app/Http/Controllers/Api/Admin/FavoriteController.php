<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Favorite\StoreFavoriteRequest;
use App\Http\Requests\Favorite\UpdateFavoriteRequest;
use App\Http\Resources\FavoriteResource;
use App\Services\FavoriteService;
use Illuminate\Http\Request;

/**
 * @OA\Tag(
 *     name="Favorite",
 *     description="CRUD Favorite"
 * )
 */
class FavoriteController extends Controller
{
    protected FavoriteService $FavoriteService;

    public function __construct(FavoriteService $FavoriteService)
    {
        $this->FavoriteService = $FavoriteService;
    }

    /**
     * @OA\Get(
     *     path="/api/favorites",
     *     summary="Danh sách Favorite (paging)",
     *     tags={"Favorite"},
     *     @OA\Parameter(name="page", in="query", required=false, @OA\Schema(type="integer", example=1)),
     *     @OA\Parameter(name="items_per_page", in="query", required=false, @OA\Schema(type="integer", example=10)),
     *     @OA\Response(
     *         response=200,
     *         description="Danh sách Favorite",
     *         @OA\JsonContent(
     *             @OA\Property(property="items", type="array", @OA\Items(ref="#/components/schemas/Favorite")),
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
        $result = $this->FavoriteService->all($request->all());

        return response()->json([
            'items' => FavoriteResource::collection(collect($result['items'] ?? [])),
            'paginate' => $result['paginate'] ?? null,
        ], 200);
    }

    /**
     * @OA\Get(
     *     path="/api/favorites/search",
     *     summary="Tìm kiếm Favorite (paging)",
     *     tags={"Favorite"},
     *     @OA\Parameter(name="keyword", in="query", required=false, @OA\Schema(type="string")),
     *     @OA\Parameter(name="page", in="query", required=false, @OA\Schema(type="integer", example=1)),
     *     @OA\Parameter(name="items_per_page", in="query", required=false, @OA\Schema(type="integer", example=10)),
     *     @OA\Response(
     *         response=200,
     *         description="Danh sách Favorite",
     *         @OA\JsonContent(
     *             @OA\Property(property="items", type="array", @OA\Items(ref="#/components/schemas/Favorite")),
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
        $result = $this->FavoriteService->search($request->all());

        return response()->json([
            'items' => FavoriteResource::collection(collect($result['items'] ?? [])),
            'paginate' => $result['paginate'] ?? null,
        ], 200);
    }

    /**
     * @OA\Get(
     *     path="/api/favorites/{id}",
     *     summary="Chi tiết Favorite",
     *     tags={"Favorite"},
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer", example=1)),
     *     @OA\Response(response=200, description="Chi tiết Favorite", @OA\JsonContent(ref="#/components/schemas/Favorite")),
     *     @OA\Response(response=404, description="Không tìm thấy")
     * )
     */
    public function show($id)
    {
        $model = $this->FavoriteService->show($id);
        if (!$model) {
            return response()->json(['message' => 'Not found'], 404);
        }

        return response()->json(new FavoriteResource($model), 200);
    }

    /**
     * @OA\Post(
     *     path="/api/favorites",
     *     summary="Tạo Favorite",
     *     tags={"Favorite"},
     *     @OA\RequestBody(required=true, @OA\JsonContent(ref="#/components/schemas/StoreFavoriteRequest")),
     *     @OA\Response(
     *         response=201,
     *         description="Tạo thành công",
     *         @OA\JsonContent(@OA\Property(property="data", ref="#/components/schemas/Favorite"))
     *     )
     * )
     */
    public function store(StoreFavoriteRequest $request)
    {
        $model = $this->FavoriteService->store($request->all());
        return response()->json(['data' => new FavoriteResource($model)], 201);
    }

    /**
     * @OA\Put(
     *     path="/api/favorites/{id}",
     *     summary="Cập nhật Favorite",
     *     tags={"Favorite"},
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer", example=1)),
     *     @OA\RequestBody(required=true, @OA\JsonContent(ref="#/components/schemas/UpdateFavoriteRequest")),
     *     @OA\Response(
     *         response=200,
     *         description="Cập nhật thành công",
     *         @OA\JsonContent(@OA\Property(property="data", ref="#/components/schemas/Favorite"))
     *     ),
     *     @OA\Response(response=404, description="Không tìm thấy")
     * )
     */
    public function update(UpdateFavoriteRequest $request, $id)
    {
        $model = $this->FavoriteService->update($id, $request->all());
        if (!$model) {
            return response()->json(['message' => 'Not found'], 404);
        }

        return response()->json(['data' => new FavoriteResource($model)], 200);
    }

    /**
     * @OA\Delete(
     *     path="/api/favorites/{id}",
     *     summary="Xóa Favorite",
     *     tags={"Favorite"},
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
        $deleted = $this->FavoriteService->destroy($id);
        return response()->json(['success' => (bool) $deleted], 200);
    }
}