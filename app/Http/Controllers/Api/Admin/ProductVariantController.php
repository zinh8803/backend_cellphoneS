<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductVariant\StoreProductVariantRequest;
use App\Http\Requests\ProductVariant\UpdateProductVariantRequest;
use App\Http\Resources\ProductVariantResource;
use App\Services\ProductVariantService;
use Illuminate\Http\Request;

/**
 * @OA\Tag(
 *     name="ProductVariant",
 *     description="CRUD ProductVariant"
 * )
 */
class ProductVariantController extends Controller
{
    protected ProductVariantService $ProductVariantService;

    public function __construct(ProductVariantService $ProductVariantService)
    {
        $this->ProductVariantService = $ProductVariantService;
    }

    /**
     * @OA\Get(
     *     path="/api/product-variants",
     *     summary="Danh sách ProductVariant (paging)",
     *     tags={"ProductVariant"},
     *     @OA\Parameter(name="page", in="query", required=false, @OA\Schema(type="integer", example=1)),
     *     @OA\Parameter(name="items_per_page", in="query", required=false, @OA\Schema(type="integer", example=10)),
     *     @OA\Response(
     *         response=200,
     *         description="Danh sách ProductVariant",
     *         @OA\JsonContent(
     *             @OA\Property(property="items", type="array", @OA\Items(ref="#/components/schemas/ProductVariant")),
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
        $result = $this->ProductVariantService->all($request->all());

        return response()->json([
            'items' => ProductVariantResource::collection(collect($result['items'] ?? [])),
            'paginate' => $result['paginate'] ?? null,
        ], 200);
    }

    /**
     * @OA\Get(
     *     path="/api/product-variants/search",
     *     summary="Tìm kiếm ProductVariant (paging)",
     *     tags={"ProductVariant"},
     *     @OA\Parameter(name="keyword", in="query", required=false, @OA\Schema(type="string")),
     *     @OA\Parameter(name="page", in="query", required=false, @OA\Schema(type="integer", example=1)),
     *     @OA\Parameter(name="items_per_page", in="query", required=false, @OA\Schema(type="integer", example=10)),
     *     @OA\Response(
     *         response=200,
     *         description="Danh sách ProductVariant",
     *         @OA\JsonContent(
     *             @OA\Property(property="items", type="array", @OA\Items(ref="#/components/schemas/ProductVariant")),
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
        $result = $this->ProductVariantService->search($request->all());

        return response()->json([
            'items' => ProductVariantResource::collection(collect($result['items'] ?? [])),
            'paginate' => $result['paginate'] ?? null,
        ], 200);
    }

    /**
     * @OA\Get(
     *     path="/api/product-variants/{id}",
     *     summary="Chi tiết ProductVariant",
     *     tags={"ProductVariant"},
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer", example=1)),
     *     @OA\Response(response=200, description="Chi tiết ProductVariant", @OA\JsonContent(ref="#/components/schemas/ProductVariant")),
     *     @OA\Response(response=404, description="Không tìm thấy")
     * )
     */
    public function show($id)
    {
        $model = $this->ProductVariantService->show($id);
        if (!$model) {
            return response()->json(['message' => 'Not found'], 404);
        }

        return response()->json(new ProductVariantResource($model), 200);
    }

    /**
     * @OA\Post(
     *     path="/api/product-variants",
     *     summary="Tạo ProductVariant",
     *     tags={"ProductVariant"},
     *     @OA\RequestBody(required=true, @OA\JsonContent(ref="#/components/schemas/StoreProductVariantRequest")),
     *     @OA\Response(
     *         response=201,
     *         description="Tạo thành công",
     *         @OA\JsonContent(@OA\Property(property="data", ref="#/components/schemas/ProductVariant"))
     *     )
     * )
     */
    public function store(StoreProductVariantRequest $request)
    {
        $model = $this->ProductVariantService->store($request->all());
        return response()->json(['data' => new ProductVariantResource($model)], 201);
    }

    /**
     * @OA\Put(
     *     path="/api/product-variants/{id}",
     *     summary="Cập nhật ProductVariant",
     *     tags={"ProductVariant"},
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer", example=1)),
     *     @OA\RequestBody(required=true, @OA\JsonContent(ref="#/components/schemas/UpdateProductVariantRequest")),
     *     @OA\Response(
     *         response=200,
     *         description="Cập nhật thành công",
     *         @OA\JsonContent(@OA\Property(property="data", ref="#/components/schemas/ProductVariant"))
     *     ),
     *     @OA\Response(response=404, description="Không tìm thấy")
     * )
     */
    public function update(UpdateProductVariantRequest $request, $id)
    {
        $model = $this->ProductVariantService->update($id, $request->all());
        if (!$model) {
            return response()->json(['message' => 'Not found'], 404);
        }

        return response()->json(['data' => new ProductVariantResource($model)], 200);
    }

    /**
     * @OA\Delete(
     *     path="/api/product-variants/{id}",
     *     summary="Xóa ProductVariant",
     *     tags={"ProductVariant"},
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
        $deleted = $this->ProductVariantService->destroy($id);
        return response()->json(['success' => (bool) $deleted], 200);
    }
}