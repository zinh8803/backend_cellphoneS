<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CouponUsage\StoreCouponUsageRequest;
use App\Http\Requests\CouponUsage\UpdateCouponUsageRequest;
use App\Http\Resources\CouponUsageResource;
use App\Services\CouponUsageService;
use Illuminate\Http\Request;

/**
 * @OA\Tag(
 *     name="CouponUsage",
 *     description="CRUD CouponUsage"
 * )
 */
class CouponUsageController extends Controller
{
    protected CouponUsageService $CouponUsageService;

    public function __construct(CouponUsageService $CouponUsageService)
    {
        $this->CouponUsageService = $CouponUsageService;
    }

    /**
     * @OA\Get(
     *     path="/api/coupon-usages",
     *     summary="Danh sách CouponUsage (paging)",
     *     tags={"CouponUsage"},
     *     @OA\Parameter(name="page", in="query", required=false, @OA\Schema(type="integer", example=1)),
     *     @OA\Parameter(name="items_per_page", in="query", required=false, @OA\Schema(type="integer", example=10)),
     *     @OA\Response(
     *         response=200,
     *         description="Danh sách CouponUsage",
     *         @OA\JsonContent(
     *             @OA\Property(property="items", type="array", @OA\Items(ref="#/components/schemas/CouponUsage")),
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
        $result = $this->CouponUsageService->all($request->all());

        return response()->json([
            'items' => CouponUsageResource::collection(collect($result['items'] ?? [])),
            'paginate' => $result['paginate'] ?? null,
        ], 200);
    }

    /**
     * @OA\Get(
     *     path="/api/coupon-usages/search",
     *     summary="Tìm kiếm CouponUsage (paging)",
     *     tags={"CouponUsage"},
     *     @OA\Parameter(name="keyword", in="query", required=false, @OA\Schema(type="string")),
     *     @OA\Parameter(name="page", in="query", required=false, @OA\Schema(type="integer", example=1)),
     *     @OA\Parameter(name="items_per_page", in="query", required=false, @OA\Schema(type="integer", example=10)),
     *     @OA\Response(
     *         response=200,
     *         description="Danh sách CouponUsage",
     *         @OA\JsonContent(
     *             @OA\Property(property="items", type="array", @OA\Items(ref="#/components/schemas/CouponUsage")),
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
        $result = $this->CouponUsageService->search($request->all());

        return response()->json([
            'items' => CouponUsageResource::collection(collect($result['items'] ?? [])),
            'paginate' => $result['paginate'] ?? null,
        ], 200);
    }

    /**
     * @OA\Get(
     *     path="/api/coupon-usages/{id}",
     *     summary="Chi tiết CouponUsage",
     *     tags={"CouponUsage"},
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer", example=1)),
     *     @OA\Response(response=200, description="Chi tiết CouponUsage", @OA\JsonContent(ref="#/components/schemas/CouponUsage")),
     *     @OA\Response(response=404, description="Không tìm thấy")
     * )
     */
    public function show($id)
    {
        $model = $this->CouponUsageService->show($id);
        if (!$model) {
            return response()->json(['message' => 'Not found'], 404);
        }

        return response()->json(new CouponUsageResource($model), 200);
    }

    /**
     * @OA\Post(
     *     path="/api/coupon-usages",
     *     summary="Tạo CouponUsage",
     *     tags={"CouponUsage"},
     *     @OA\RequestBody(required=true, @OA\JsonContent(ref="#/components/schemas/StoreCouponUsageRequest")),
     *     @OA\Response(
     *         response=201,
     *         description="Tạo thành công",
     *         @OA\JsonContent(@OA\Property(property="data", ref="#/components/schemas/CouponUsage"))
     *     )
     * )
     */
    public function store(StoreCouponUsageRequest $request)
    {
        $model = $this->CouponUsageService->store($request->all());
        return response()->json(['data' => new CouponUsageResource($model)], 201);
    }

    /**
     * @OA\Put(
     *     path="/api/coupon-usages/{id}",
     *     summary="Cập nhật CouponUsage",
     *     tags={"CouponUsage"},
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer", example=1)),
     *     @OA\RequestBody(required=true, @OA\JsonContent(ref="#/components/schemas/UpdateCouponUsageRequest")),
     *     @OA\Response(
     *         response=200,
     *         description="Cập nhật thành công",
     *         @OA\JsonContent(@OA\Property(property="data", ref="#/components/schemas/CouponUsage"))
     *     ),
     *     @OA\Response(response=404, description="Không tìm thấy")
     * )
     */
    public function update(UpdateCouponUsageRequest $request, $id)
    {
        $model = $this->CouponUsageService->update($id, $request->all());
        if (!$model) {
            return response()->json(['message' => 'Not found'], 404);
        }

        return response()->json(['data' => new CouponUsageResource($model)], 200);
    }

    /**
     * @OA\Delete(
     *     path="/api/coupon-usages/{id}",
     *     summary="Xóa CouponUsage",
     *     tags={"CouponUsage"},
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
        $deleted = $this->CouponUsageService->destroy($id);
        return response()->json(['success' => (bool) $deleted], 200);
    }
}