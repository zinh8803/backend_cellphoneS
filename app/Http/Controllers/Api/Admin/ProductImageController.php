<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductImage\StoreProductImageRequest;
use App\Http\Requests\ProductImage\UpdateProductImageRequest;
use App\Http\Resources\ProductImageResource;
use App\Services\ProductImageService;
use Illuminate\Http\Request;

/**
 * @OA\Tag(
 *     name="ProductImage",
 *     description="CRUD ProductImage"
 * )
 */
class ProductImageController extends Controller
{
    protected ProductImageService $ProductImageService;

    public function __construct(ProductImageService $ProductImageService)
    {
        $this->ProductImageService = $ProductImageService;
    }

    /**
     * @OA\Get(
     *     path="/api/product-images",
     *     summary="Danh sách ProductImage (paging)",
     *     tags={"ProductImage"},
     *     @OA\Parameter(name="page", in="query", required=false, @OA\Schema(type="integer", example=1)),
     *     @OA\Parameter(name="items_per_page", in="query", required=false, @OA\Schema(type="integer", example=10)),
     *     @OA\Response(
     *         response=200,
     *         description="Danh sách ProductImage",
     *         @OA\JsonContent(
     *             @OA\Property(property="items", type="array", @OA\Items(ref="#/components/schemas/ProductImage")),
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
        $result = $this->ProductImageService->all($request->all());

        return response()->json([
            'items' => ProductImageResource::collection(collect($result['items'] ?? [])),
            'paginate' => $result['paginate'] ?? null,
        ], 200);
    }

    /**
     * @OA\Get(
     *     path="/api/product-images/search",
     *     summary="Tìm kiếm ProductImage (paging)",
     *     tags={"ProductImage"},
     *     @OA\Parameter(name="keyword", in="query", required=false, @OA\Schema(type="string")),
     *     @OA\Parameter(name="page", in="query", required=false, @OA\Schema(type="integer", example=1)),
     *     @OA\Parameter(name="items_per_page", in="query", required=false, @OA\Schema(type="integer", example=10)),
     *     @OA\Response(
     *         response=200,
     *         description="Danh sách ProductImage",
     *         @OA\JsonContent(
     *             @OA\Property(property="items", type="array", @OA\Items(ref="#/components/schemas/ProductImage")),
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
        $result = $this->ProductImageService->search($request->all());

        return response()->json([
            'items' => ProductImageResource::collection(collect($result['items'] ?? [])),
            'paginate' => $result['paginate'] ?? null,
        ], 200);
    }

    /**
     * @OA\Get(
     *     path="/api/product-images/{id}",
     *     summary="Chi tiết ProductImage",
     *     tags={"ProductImage"},
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer", example=1)),
     *     @OA\Response(response=200, description="Chi tiết ProductImage", @OA\JsonContent(ref="#/components/schemas/ProductImage")),
     *     @OA\Response(response=404, description="Không tìm thấy")
     * )
     */
    public function show($id)
    {
        $model = $this->ProductImageService->show($id);
        if (!$model) {
            return response()->json(['message' => 'Not found'], 404);
        }

        return response()->json(new ProductImageResource($model), 200);
    }

    /**
     * @OA\Post(
     *     path="/api/product-images",
     *     summary="Tạo ProductImage",
     *     tags={"ProductImage"},
     *     @OA\RequestBody(required=true, @OA\JsonContent(ref="#/components/schemas/StoreProductImageRequest")),
     *     @OA\Response(
     *         response=201,
     *         description="Tạo thành công",
     *         @OA\JsonContent(@OA\Property(property="data", ref="#/components/schemas/ProductImage"))
     *     )
     * )
     */
    public function store(StoreProductImageRequest $request)
    {
        $model = $this->ProductImageService->store($request->all());
        return response()->json(['data' => new ProductImageResource($model)], 201);
    }

    /**
     * @OA\Put(
     *     path="/api/product-images/{id}",
     *     summary="Cập nhật ProductImage",
     *     tags={"ProductImage"},
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer", example=1)),
     *     @OA\RequestBody(required=true, @OA\JsonContent(ref="#/components/schemas/UpdateProductImageRequest")),
     *     @OA\Response(
     *         response=200,
     *         description="Cập nhật thành công",
     *         @OA\JsonContent(@OA\Property(property="data", ref="#/components/schemas/ProductImage"))
     *     ),
     *     @OA\Response(response=404, description="Không tìm thấy")
     * )
     */
    public function update(UpdateProductImageRequest $request, $id)
    {
        $model = $this->ProductImageService->update($id, $request->all());
        if (!$model) {
            return response()->json(['message' => 'Not found'], 404);
        }

        return response()->json(['data' => new ProductImageResource($model)], 200);
    }

    /**
     * @OA\Delete(
     *     path="/api/product-images/{id}",
     *     summary="Xóa ProductImage",
     *     tags={"ProductImage"},
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
        $deleted = $this->ProductImageService->destroy($id);
        return response()->json(['success' => (bool) $deleted], 200);
    }
}