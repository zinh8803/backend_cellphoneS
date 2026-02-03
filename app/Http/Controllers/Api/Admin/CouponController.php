<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Coupon\StoreCouponRequest;
use App\Http\Requests\Coupon\UpdateCouponRequest;
use App\Http\Resources\CouponResource;
use App\Services\CouponService;
use Illuminate\Http\Request;

/**
 * @OA\Tag(
 *     name="Coupon",
 *     description="CRUD Coupon"
 * )
 */
class CouponController extends Controller
{
    protected CouponService $CouponService;

    public function __construct(CouponService $CouponService)
    {
        $this->CouponService = $CouponService;
    }

    /**
     * @OA\Get(
     *     path="/api/coupons",
     *     summary="Danh sách Coupon (paging)",
     *     tags={"Coupon"},
     *     @OA\Parameter(name="page", in="query", required=false, @OA\Schema(type="integer", example=1)),
     *     @OA\Parameter(name="items_per_page", in="query", required=false, @OA\Schema(type="integer", example=10)),
     *     @OA\Response(
     *         response=200,
     *         description="Danh sách Coupon",
     *         @OA\JsonContent(
     *             @OA\Property(property="items", type="array", @OA\Items(ref="#/components/schemas/Coupon")),
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
        $result = $this->CouponService->all($request->all());

        return response()->json([
            'items' => CouponResource::collection(collect($result['items'] ?? [])),
            'paginate' => $result['paginate'] ?? null,
        ], 200);
    }

    /**
     * @OA\Get(
     *     path="/api/coupons/search",
     *     summary="Tìm kiếm Coupon (paging)",
     *     tags={"Coupon"},
     *     @OA\Parameter(name="keyword", in="query", required=false, @OA\Schema(type="string")),
     *     @OA\Parameter(name="page", in="query", required=false, @OA\Schema(type="integer", example=1)),
     *     @OA\Parameter(name="items_per_page", in="query", required=false, @OA\Schema(type="integer", example=10)),
     *     @OA\Response(
     *         response=200,
     *         description="Danh sách Coupon",
     *         @OA\JsonContent(
     *             @OA\Property(property="items", type="array", @OA\Items(ref="#/components/schemas/Coupon")),
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
        $result = $this->CouponService->search($request->all());

        return response()->json([
            'items' => CouponResource::collection(collect($result['items'] ?? [])),
            'paginate' => $result['paginate'] ?? null,
        ], 200);
    }

    /**
     * @OA\Get(
     *     path="/api/coupons/{id}",
     *     summary="Chi tiết Coupon",
     *     tags={"Coupon"},
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer", example=1)),
     *     @OA\Response(response=200, description="Chi tiết Coupon", @OA\JsonContent(ref="#/components/schemas/Coupon")),
     *     @OA\Response(response=404, description="Không tìm thấy")
     * )
     */
    public function show($id)
    {
        $model = $this->CouponService->show($id);
        if (!$model) {
            return response()->json(['message' => 'Not found'], 404);
        }

        return response()->json(new CouponResource($model), 200);
    }

    /**
     * @OA\Post(
     *     path="/api/coupons",
     *     summary="Tạo Coupon",
     *     tags={"Coupon"},
     *     @OA\RequestBody(required=true, @OA\JsonContent(ref="#/components/schemas/StoreCouponRequest")),
     *     @OA\Response(
     *         response=201,
     *         description="Tạo thành công",
     *         @OA\JsonContent(@OA\Property(property="data", ref="#/components/schemas/Coupon"))
     *     )
     * )
     */
    public function store(StoreCouponRequest $request)
    {
        $model = $this->CouponService->store($request->all());
        return response()->json(['data' => new CouponResource($model)], 201);
    }

    /**
     * @OA\Put(
     *     path="/api/coupons/{id}",
     *     summary="Cập nhật Coupon",
     *     tags={"Coupon"},
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer", example=1)),
     *     @OA\RequestBody(required=true, @OA\JsonContent(ref="#/components/schemas/UpdateCouponRequest")),
     *     @OA\Response(
     *         response=200,
     *         description="Cập nhật thành công",
     *         @OA\JsonContent(@OA\Property(property="data", ref="#/components/schemas/Coupon"))
     *     ),
     *     @OA\Response(response=404, description="Không tìm thấy")
     * )
     */
    public function update(UpdateCouponRequest $request, $id)
    {
        $model = $this->CouponService->update($id, $request->all());
        if (!$model) {
            return response()->json(['message' => 'Not found'], 404);
        }

        return response()->json(['data' => new CouponResource($model)], 200);
    }

    /**
     * @OA\Delete(
     *     path="/api/coupons/{id}",
     *     summary="Xóa Coupon",
     *     tags={"Coupon"},
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
        $deleted = $this->CouponService->destroy($id);
        return response()->json(['success' => (bool) $deleted], 200);
    }
}