<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CartDetail\StoreCartDetailRequest;
use App\Http\Requests\CartDetail\UpdateCartDetailRequest;
use App\Http\Resources\CartDetailResource;
use App\Services\CartDetailService;
use Illuminate\Http\Request;

/**
 * @OA\Tag(
 *     name="CartDetail",
 *     description="CRUD CartDetail"
 * )
 */
class CartDetailController extends Controller
{
    protected CartDetailService $CartDetailService;

    public function __construct(CartDetailService $CartDetailService)
    {
        $this->CartDetailService = $CartDetailService;
    }

    /**
     * @OA\Get(
     *     path="/api/cart-details",
     *     summary="Danh sách CartDetail (paging)",
     *     tags={"CartDetail"},
     *     @OA\Parameter(name="page", in="query", required=false, @OA\Schema(type="integer", example=1)),
     *     @OA\Parameter(name="items_per_page", in="query", required=false, @OA\Schema(type="integer", example=10)),
     *     @OA\Response(
     *         response=200,
     *         description="Danh sách CartDetail",
     *         @OA\JsonContent(
     *             @OA\Property(property="items", type="array", @OA\Items(ref="#/components/schemas/CartDetail")),
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
        $result = $this->CartDetailService->all($request->all());

        return response()->json([
            'items' => CartDetailResource::collection(collect($result['items'] ?? [])),
            'paginate' => $result['paginate'] ?? null,
        ], 200);
    }

    /**
     * @OA\Get(
     *     path="/api/cart-details/search",
     *     summary="Tìm kiếm CartDetail (paging)",
     *     tags={"CartDetail"},
     *     @OA\Parameter(name="keyword", in="query", required=false, @OA\Schema(type="string")),
     *     @OA\Parameter(name="page", in="query", required=false, @OA\Schema(type="integer", example=1)),
     *     @OA\Parameter(name="items_per_page", in="query", required=false, @OA\Schema(type="integer", example=10)),
     *     @OA\Response(
     *         response=200,
     *         description="Danh sách CartDetail",
     *         @OA\JsonContent(
     *             @OA\Property(property="items", type="array", @OA\Items(ref="#/components/schemas/CartDetail")),
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
        $result = $this->CartDetailService->search($request->all());

        return response()->json([
            'items' => CartDetailResource::collection(collect($result['items'] ?? [])),
            'paginate' => $result['paginate'] ?? null,
        ], 200);
    }

    /**
     * @OA\Get(
     *     path="/api/cart-details/{id}",
     *     summary="Chi tiết CartDetail",
     *     tags={"CartDetail"},
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer", example=1)),
     *     @OA\Response(response=200, description="Chi tiết CartDetail", @OA\JsonContent(ref="#/components/schemas/CartDetail")),
     *     @OA\Response(response=404, description="Không tìm thấy")
     * )
     */
    public function show($id)
    {
        $model = $this->CartDetailService->show($id);
        if (!$model) {
            return response()->json(['message' => 'Not found'], 404);
        }

        return response()->json(new CartDetailResource($model), 200);
    }

    /**
     * @OA\Post(
     *     path="/api/cart-details",
     *     summary="Tạo CartDetail",
     *     tags={"CartDetail"},
     *     @OA\RequestBody(required=true, @OA\JsonContent(ref="#/components/schemas/StoreCartDetailRequest")),
     *     @OA\Response(
     *         response=201,
     *         description="Tạo thành công",
     *         @OA\JsonContent(@OA\Property(property="data", ref="#/components/schemas/CartDetail"))
     *     )
     * )
     */
    public function store(StoreCartDetailRequest $request)
    {
        $model = $this->CartDetailService->store($request->all());
        return response()->json(['data' => new CartDetailResource($model)], 201);
    }

    /**
     * @OA\Put(
     *     path="/api/cart-details/{id}",
     *     summary="Cập nhật CartDetail",
     *     tags={"CartDetail"},
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer", example=1)),
     *     @OA\RequestBody(required=true, @OA\JsonContent(ref="#/components/schemas/UpdateCartDetailRequest")),
     *     @OA\Response(
     *         response=200,
     *         description="Cập nhật thành công",
     *         @OA\JsonContent(@OA\Property(property="data", ref="#/components/schemas/CartDetail"))
     *     ),
     *     @OA\Response(response=404, description="Không tìm thấy")
     * )
     */
    public function update(UpdateCartDetailRequest $request, $id)
    {
        $model = $this->CartDetailService->update($id, $request->all());
        if (!$model) {
            return response()->json(['message' => 'Not found'], 404);
        }

        return response()->json(['data' => new CartDetailResource($model)], 200);
    }

    /**
     * @OA\Delete(
     *     path="/api/cart-details/{id}",
     *     summary="Xóa CartDetail",
     *     tags={"CartDetail"},
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
        $deleted = $this->CartDetailService->destroy($id);
        return response()->json(['success' => (bool) $deleted], 200);
    }
}