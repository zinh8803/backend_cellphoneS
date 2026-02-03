<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\FlashSale\StoreFlashSaleRequest;
use App\Http\Requests\FlashSale\UpdateFlashSaleRequest;
use App\Http\Resources\FlashSaleResource;
use App\Services\FlashSaleService;
use Illuminate\Http\Request;

/**
 * @OA\Tag(
 *     name="FlashSale",
 *     description="CRUD FlashSale"
 * )
 */
class FlashSaleController extends Controller
{
    protected FlashSaleService $FlashSaleService;

    public function __construct(FlashSaleService $FlashSaleService)
    {
        $this->FlashSaleService = $FlashSaleService;
    }

    /**
     * @OA\Get(
     *     path="/api/flash-sales",
     *     summary="Danh sách FlashSale (paging)",
     *     tags={"FlashSale"},
     *     @OA\Parameter(name="page", in="query", required=false, @OA\Schema(type="integer", example=1)),
     *     @OA\Parameter(name="items_per_page", in="query", required=false, @OA\Schema(type="integer", example=10)),
     *     @OA\Response(
     *         response=200,
     *         description="Danh sách FlashSale",
     *         @OA\JsonContent(
     *             @OA\Property(property="items", type="array", @OA\Items(ref="#/components/schemas/FlashSale")),
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
        $result = $this->FlashSaleService->all($request->all());

        return response()->json([
            'items' => FlashSaleResource::collection(collect($result['items'] ?? [])),
            'paginate' => $result['paginate'] ?? null,
        ], 200);
    }

    /**
     * @OA\Get(
     *     path="/api/flash-sales/search",
     *     summary="Tìm kiếm FlashSale (paging)",
     *     tags={"FlashSale"},
     *     @OA\Parameter(name="keyword", in="query", required=false, @OA\Schema(type="string")),
     *     @OA\Parameter(name="page", in="query", required=false, @OA\Schema(type="integer", example=1)),
     *     @OA\Parameter(name="items_per_page", in="query", required=false, @OA\Schema(type="integer", example=10)),
     *     @OA\Response(
     *         response=200,
     *         description="Danh sách FlashSale",
     *         @OA\JsonContent(
     *             @OA\Property(property="items", type="array", @OA\Items(ref="#/components/schemas/FlashSale")),
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
        $result = $this->FlashSaleService->search($request->all());

        return response()->json([
            'items' => FlashSaleResource::collection(collect($result['items'] ?? [])),
            'paginate' => $result['paginate'] ?? null,
        ], 200);
    }

    /**
     * @OA\Get(
     *     path="/api/flash-sales/{id}",
     *     summary="Chi tiết FlashSale",
     *     tags={"FlashSale"},
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer", example=1)),
     *     @OA\Response(response=200, description="Chi tiết FlashSale", @OA\JsonContent(ref="#/components/schemas/FlashSale")),
     *     @OA\Response(response=404, description="Không tìm thấy")
     * )
     */
    public function show($id)
    {
        $model = $this->FlashSaleService->show($id);
        if (!$model) {
            return response()->json(['message' => 'Not found'], 404);
        }

        return response()->json(new FlashSaleResource($model), 200);
    }

    /**
     * @OA\Post(
     *     path="/api/flash-sales",
     *     summary="Tạo FlashSale",
     *     tags={"FlashSale"},
     *     @OA\RequestBody(required=true, @OA\JsonContent(ref="#/components/schemas/StoreFlashSaleRequest")),
     *     @OA\Response(
     *         response=201,
     *         description="Tạo thành công",
     *         @OA\JsonContent(@OA\Property(property="data", ref="#/components/schemas/FlashSale"))
     *     )
     * )
     */
    public function store(StoreFlashSaleRequest $request)
    {
        $model = $this->FlashSaleService->store($request->all());
        return response()->json(['data' => new FlashSaleResource($model)], 201);
    }

    /**
     * @OA\Put(
     *     path="/api/flash-sales/{id}",
     *     summary="Cập nhật FlashSale",
     *     tags={"FlashSale"},
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer", example=1)),
     *     @OA\RequestBody(required=true, @OA\JsonContent(ref="#/components/schemas/UpdateFlashSaleRequest")),
     *     @OA\Response(
     *         response=200,
     *         description="Cập nhật thành công",
     *         @OA\JsonContent(@OA\Property(property="data", ref="#/components/schemas/FlashSale"))
     *     ),
     *     @OA\Response(response=404, description="Không tìm thấy")
     * )
     */
    public function update(UpdateFlashSaleRequest $request, $id)
    {
        $model = $this->FlashSaleService->update($id, $request->all());
        if (!$model) {
            return response()->json(['message' => 'Not found'], 404);
        }

        return response()->json(['data' => new FlashSaleResource($model)], 200);
    }

    /**
     * @OA\Delete(
     *     path="/api/flash-sales/{id}",
     *     summary="Xóa FlashSale",
     *     tags={"FlashSale"},
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
        $deleted = $this->FlashSaleService->destroy($id);
        return response()->json(['success' => (bool) $deleted], 200);
    }
}