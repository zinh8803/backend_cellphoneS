<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Color\StoreColorRequest;
use App\Http\Requests\Color\UpdateColorRequest;
use App\Http\Resources\colorResource;
use App\Services\ColorService;
use Illuminate\Http\Request;

/**
 * @OA\Tag(
 *     name="Color",
 *     description="Quản lý màu sắc"
 * )
 */
class ColorController extends Controller
{
    protected ColorService $colorService;

    public function __construct(ColorService $colorService)
    {
        $this->colorService = $colorService;
    }

    /**
     * @OA\Get(
     *     path="/api/colors",
     *     summary="Danh sách màu (paging)",
     *     tags={"Color"},
     *     @OA\Parameter(
     *         name="page",
     *         in="query",
     *         required=false,
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Parameter(
     *         name="items_per_page",
     *         in="query",
     *         required=false,
     *         @OA\Schema(type="integer", example=10)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Danh sách màu",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="items",
     *                 type="array",
     *                 @OA\Items(ref="#/components/schemas/Color")
     *             ),
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
        $result = $this->colorService->all($request->all());
        return response()->json([
            'items' => colorResource::collection(collect($result['items'] ?? [])),
            'paginate' => $result['paginate'] ?? null,
        ], 200);
    }

    /**
     * @OA\Get(
     *     path="/api/colors/search",
     *     summary="Tìm kiếm màu (paging)",
     *     tags={"Color"},
     *     @OA\Parameter(
     *         name="keyword",
     *         in="query",
     *         required=false,
     *         @OA\Schema(type="string", example="red")
     *     ),
     *     @OA\Parameter(
     *         name="page",
     *         in="query",
     *         required=false,
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Parameter(
     *         name="items_per_page",
     *         in="query",
     *         required=false,
     *         @OA\Schema(type="integer", example=10)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Danh sách màu",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="items",
     *                 type="array",
     *                 @OA\Items(ref="#/components/schemas/Color")
     *             ),
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
        $result = $this->colorService->search($request->all());
        return response()->json([
            'items' => colorResource::collection(collect($result['items'] ?? [])),
            'paginate' => $result['paginate'] ?? null,
        ], 200);
    }

    /**
     * @OA\Get(
     *     path="/api/colors/{id}",
     *     summary="Chi tiết màu",
     *     tags={"Color"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Chi tiết màu",
     *         @OA\JsonContent(ref="#/components/schemas/Color")
     *     ),
     *     @OA\Response(response=404, description="Không tìm thấy")
     * )
     */
    public function show($id)
    {
        $color = $this->colorService->show($id);
        if (!$color) {
            return response()->json(['message' => 'Not found'], 404);
        }
        return response()->json(new colorResource($color), 200);
    }

    /**
     * @OA\Post(
     *     path="/api/colors",
     *     summary="Tạo màu",
     *     tags={"Color"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/StoreColorRequest")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Tạo thành công",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", ref="#/components/schemas/Color")
     *         )
     *     )
     * )
     */
    public function store(StoreColorRequest $request)
    {
        $color = $this->colorService->store($request->only(['name', 'code']));
        return response()->json(['data' => new colorResource($color)], 201);
    }

    /**
     * @OA\Put(
     *     path="/api/colors/{id}",
     *     summary="Cập nhật màu",
     *     tags={"Color"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/UpdateColorRequest")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Cập nhật thành công",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", ref="#/components/schemas/Color")
     *         )
     *     ),
     *     @OA\Response(response=404, description="Không tìm thấy")
     * )
     */
    public function update(UpdateColorRequest $request, $id)
    {
        $color = $this->colorService->update($id, $request->only(['name', 'code']));
        if (!$color) {
            return response()->json(['message' => 'Not found'], 404);
        }
        return response()->json(['data' => new colorResource($color)], 200);
    }

    /**
     * @OA\Delete(
     *     path="/api/colors/{id}",
     *     summary="Xóa màu",
     *     tags={"Color"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Xóa thành công",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true)
     *         )
     *     )
     * )
     */
    public function destroy($id)
    {
        $deleted = $this->colorService->destroy($id);
        return response()->json(['success' => (bool) $deleted], 200);
    }
}
