<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Shipping\StoreShippingRequest;
use App\Http\Requests\Shipping\UpdateShippingRequest;
use App\Http\Resources\ShippingResource;
use App\Services\ShippingService;
use Illuminate\Http\Request;

/**
 * @OA\Tag(
 *     name="Shipping",
 *     description="CRUD Shipping"
 * )
 */
class ShippingController extends Controller
{
    protected ShippingService $ShippingService;

    public function __construct(ShippingService $ShippingService)
    {
        $this->ShippingService = $ShippingService;
    }

    /**
     * @OA\Get(
     *     path="/api/shippings",
     *     summary="Danh sách Shipping (paging)",
     *     tags={"Shipping"},
     *     @OA\Parameter(name="page", in="query", required=false, @OA\Schema(type="integer", example=1)),
     *     @OA\Parameter(name="items_per_page", in="query", required=false, @OA\Schema(type="integer", example=10)),
     *     @OA\Response(
     *         response=200,
     *         description="Danh sách Shipping",
     *         @OA\JsonContent(
     *             @OA\Property(property="items", type="array", @OA\Items(ref="#/components/schemas/Shipping")),
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
        $result = $this->ShippingService->all($request->all());

        return response()->json([
            'items' => ShippingResource::collection(collect($result['items'] ?? [])),
            'paginate' => $result['paginate'] ?? null,
        ], 200);
    }

    /**
     * @OA\Get(
     *     path="/api/shippings/search",
     *     summary="Tìm kiếm Shipping (paging)",
     *     tags={"Shipping"},
     *     @OA\Parameter(name="keyword", in="query", required=false, @OA\Schema(type="string")),
     *     @OA\Parameter(name="page", in="query", required=false, @OA\Schema(type="integer", example=1)),
     *     @OA\Parameter(name="items_per_page", in="query", required=false, @OA\Schema(type="integer", example=10)),
     *     @OA\Response(
     *         response=200,
     *         description="Danh sách Shipping",
     *         @OA\JsonContent(
     *             @OA\Property(property="items", type="array", @OA\Items(ref="#/components/schemas/Shipping")),
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
        $result = $this->ShippingService->search($request->all());

        return response()->json([
            'items' => ShippingResource::collection(collect($result['items'] ?? [])),
            'paginate' => $result['paginate'] ?? null,
        ], 200);
    }

    /**
     * @OA\Get(
     *     path="/api/shippings/{id}",
     *     summary="Chi tiết Shipping",
     *     tags={"Shipping"},
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer", example=1)),
     *     @OA\Response(response=200, description="Chi tiết Shipping", @OA\JsonContent(ref="#/components/schemas/Shipping")),
     *     @OA\Response(response=404, description="Không tìm thấy")
     * )
     */
    public function show($id)
    {
        $model = $this->ShippingService->show($id);
        if (!$model) {
            return response()->json(['message' => 'Not found'], 404);
        }

        return response()->json(new ShippingResource($model), 200);
    }

    /**
     * @OA\Post(
     *     path="/api/shippings",
     *     summary="Tạo Shipping",
     *     tags={"Shipping"},
     *     @OA\RequestBody(required=true, @OA\JsonContent(ref="#/components/schemas/StoreShippingRequest")),
     *     @OA\Response(
     *         response=201,
     *         description="Tạo thành công",
     *         @OA\JsonContent(@OA\Property(property="data", ref="#/components/schemas/Shipping"))
     *     )
     * )
     */
    public function store(StoreShippingRequest $request)
    {
        $model = $this->ShippingService->store($request->all());
        return response()->json(['data' => new ShippingResource($model)], 201);
    }

    /**
     * @OA\Put(
     *     path="/api/shippings/{id}",
     *     summary="Cập nhật Shipping",
     *     tags={"Shipping"},
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer", example=1)),
     *     @OA\RequestBody(required=true, @OA\JsonContent(ref="#/components/schemas/UpdateShippingRequest")),
     *     @OA\Response(
     *         response=200,
     *         description="Cập nhật thành công",
     *         @OA\JsonContent(@OA\Property(property="data", ref="#/components/schemas/Shipping"))
     *     ),
     *     @OA\Response(response=404, description="Không tìm thấy")
     * )
     */
    public function update(UpdateShippingRequest $request, $id)
    {
        $model = $this->ShippingService->update($id, $request->all());
        if (!$model) {
            return response()->json(['message' => 'Not found'], 404);
        }

        return response()->json(['data' => new ShippingResource($model)], 200);
    }

    /**
     * @OA\Delete(
     *     path="/api/shippings/{id}",
     *     summary="Xóa Shipping",
     *     tags={"Shipping"},
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
        $deleted = $this->ShippingService->destroy($id);
        return response()->json(['success' => (bool) $deleted], 200);
    }
}