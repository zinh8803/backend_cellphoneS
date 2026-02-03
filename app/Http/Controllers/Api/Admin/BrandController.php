<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Brand\StoreBrandRequest;
use App\Http\Requests\Brand\UpdateBrandRequest;
use App\Http\Resources\BrandResource;
use App\Services\BrandService;
use Illuminate\Http\Request;

/**
 * @OA\Tag(
 *     name="Brand",
 *     description="Quản lý thương hiệu"
 * )
 */
class BrandController extends Controller
{
    protected BrandService $brandService;

    public function __construct(BrandService $brandService)
    {
        $this->brandService = $brandService;
    }

    /**
     * @OA\Get(
     *     path="/api/brands",
     *     summary="Danh sách brand (paging)",
     *     tags={"Brand"},
     *     @OA\Parameter(name="page", in="query", required=false, @OA\Schema(type="integer", example=1)),
     *     @OA\Parameter(name="items_per_page", in="query", required=false, @OA\Schema(type="integer", example=10)),
     *     @OA\Response(
     *         response=200,
     *         description="Danh sách brand",
     *         @OA\JsonContent(
     *             @OA\Property(property="items", type="array", @OA\Items(ref="#/components/schemas/Brand")),
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
        $result = $this->brandService->all($request->all());

        return response()->json([
            'items' => BrandResource::collection(collect($result['items'] ?? [])),
            'paginate' => $result['paginate'] ?? null,
        ], 200);
    }

    /**
     * @OA\Get(
     *     path="/api/brands/search",
     *     summary="Tìm kiếm brand (paging)",
     *     tags={"Brand"},
     *     @OA\Parameter(name="keyword", in="query", required=false, @OA\Schema(type="string", example="app")),
     *     @OA\Parameter(name="page", in="query", required=false, @OA\Schema(type="integer", example=1)),
     *     @OA\Parameter(name="items_per_page", in="query", required=false, @OA\Schema(type="integer", example=10)),
     *     @OA\Response(
     *         response=200,
     *         description="Danh sách brand",
     *         @OA\JsonContent(
     *             @OA\Property(property="items", type="array", @OA\Items(ref="#/components/schemas/Brand")),
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
        $result = $this->brandService->search($request->all());

        return response()->json([
            'items' => BrandResource::collection(collect($result['items'] ?? [])),
            'paginate' => $result['paginate'] ?? null,
        ], 200);
    }

    /**
     * @OA\Get(
     *     path="/api/brands/{id}",
     *     summary="Chi tiết brand",
     *     tags={"Brand"},
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer", example=1)),
     *     @OA\Response(response=200, description="Chi tiết brand", @OA\JsonContent(ref="#/components/schemas/Brand")),
     *     @OA\Response(response=404, description="Không tìm thấy")
     * )
     */
    public function show($id)
    {
        $brand = $this->brandService->show($id);
        if (!$brand) {
            return response()->json(['message' => 'Not found'], 404);
        }

        return response()->json(new BrandResource($brand), 200);
    }

    /**
     * @OA\Post(
     *     path="/api/brands",
     *     summary="Tạo brand",
     *     tags={"Brand"},
     *     @OA\RequestBody(required=true, @OA\JsonContent(ref="#/components/schemas/StoreBrandRequest")),
     *     @OA\Response(
     *         response=201,
     *         description="Tạo thành công",
     *         @OA\JsonContent(@OA\Property(property="data", ref="#/components/schemas/Brand"))
     *     )
     * )
     */
    public function store(StoreBrandRequest $request)
    {
        $brand = $this->brandService->store($request->only(['name', 'slug']));
        return response()->json(['data' => new BrandResource($brand)], 201);
    }

    /**
     * @OA\Put(
     *     path="/api/brands/{id}",
     *     summary="Cập nhật brand",
     *     tags={"Brand"},
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer", example=1)),
     *     @OA\RequestBody(required=true, @OA\JsonContent(ref="#/components/schemas/UpdateBrandRequest")),
     *     @OA\Response(
     *         response=200,
     *         description="Cập nhật thành công",
     *         @OA\JsonContent(@OA\Property(property="data", ref="#/components/schemas/Brand"))
     *     ),
     *     @OA\Response(response=404, description="Không tìm thấy")
     * )
     */
    public function update(UpdateBrandRequest $request, $id)
    {
        $brand = $this->brandService->update($id, $request->only(['name', 'slug']));
        if (!$brand) {
            return response()->json(['message' => 'Not found'], 404);
        }

        return response()->json(['data' => new BrandResource($brand)], 200);
    }

    /**
     * @OA\Delete(
     *     path="/api/brands/{id}",
     *     summary="Xóa brand",
     *     tags={"Brand"},
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
        $deleted = $this->brandService->destroy($id);
        return response()->json(['success' => (bool) $deleted], 200);
    }
}
