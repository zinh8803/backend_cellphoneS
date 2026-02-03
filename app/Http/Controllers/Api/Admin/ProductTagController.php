<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductTag\StoreProductTagRequest;
use App\Http\Requests\ProductTag\UpdateProductTagRequest;
use App\Http\Resources\ProductTagResource;
use App\Services\ProductTagService;
use Illuminate\Http\Request;

/**
 * @OA\Tag(
 *     name="ProductTag",
 *     description="CRUD ProductTag"
 * )
 */
class ProductTagController extends Controller
{
    protected ProductTagService $ProductTagService;

    public function __construct(ProductTagService $ProductTagService)
    {
        $this->ProductTagService = $ProductTagService;
    }

    /**
     * @OA\Get(
     *     path="/api/product-tags",
     *     summary="Danh sách ProductTag (paging)",
     *     tags={"ProductTag"},
     *     @OA\Parameter(name="page", in="query", required=false, @OA\Schema(type="integer", example=1)),
     *     @OA\Parameter(name="items_per_page", in="query", required=false, @OA\Schema(type="integer", example=10)),
     *     @OA\Response(
     *         response=200,
     *         description="Danh sách ProductTag",
     *         @OA\JsonContent(
     *             @OA\Property(property="items", type="array", @OA\Items(ref="#/components/schemas/ProductTag")),
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
        $result = $this->ProductTagService->all($request->all());

        return response()->json([
            'items' => ProductTagResource::collection(collect($result['items'] ?? [])),
            'paginate' => $result['paginate'] ?? null,
        ], 200);
    }

    /**
     * @OA\Get(
     *     path="/api/product-tags/search",
     *     summary="Tìm kiếm ProductTag (paging)",
     *     tags={"ProductTag"},
     *     @OA\Parameter(name="keyword", in="query", required=false, @OA\Schema(type="string")),
     *     @OA\Parameter(name="page", in="query", required=false, @OA\Schema(type="integer", example=1)),
     *     @OA\Parameter(name="items_per_page", in="query", required=false, @OA\Schema(type="integer", example=10)),
     *     @OA\Response(
     *         response=200,
     *         description="Danh sách ProductTag",
     *         @OA\JsonContent(
     *             @OA\Property(property="items", type="array", @OA\Items(ref="#/components/schemas/ProductTag")),
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
        $result = $this->ProductTagService->search($request->all());

        return response()->json([
            'items' => ProductTagResource::collection(collect($result['items'] ?? [])),
            'paginate' => $result['paginate'] ?? null,
        ], 200);
    }

    /**
     * @OA\Get(
     *     path="/api/product-tags/{id}",
     *     summary="Chi tiết ProductTag",
     *     tags={"ProductTag"},
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer", example=1)),
     *     @OA\Response(response=200, description="Chi tiết ProductTag", @OA\JsonContent(ref="#/components/schemas/ProductTag")),
     *     @OA\Response(response=404, description="Không tìm thấy")
     * )
     */
    public function show($id)
    {
        $model = $this->ProductTagService->show($id);
        if (!$model) {
            return response()->json(['message' => 'Not found'], 404);
        }

        return response()->json(new ProductTagResource($model), 200);
    }

    /**
     * @OA\Post(
     *     path="/api/product-tags",
     *     summary="Tạo ProductTag",
     *     tags={"ProductTag"},
     *     @OA\RequestBody(required=true, @OA\JsonContent(ref="#/components/schemas/StoreProductTagRequest")),
     *     @OA\Response(
     *         response=201,
     *         description="Tạo thành công",
     *         @OA\JsonContent(@OA\Property(property="data", ref="#/components/schemas/ProductTag"))
     *     )
     * )
     */
    public function store(StoreProductTagRequest $request)
    {
        $model = $this->ProductTagService->store($request->all());
        return response()->json(['data' => new ProductTagResource($model)], 201);
    }

    /**
     * @OA\Put(
     *     path="/api/product-tags/{id}",
     *     summary="Cập nhật ProductTag",
     *     tags={"ProductTag"},
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer", example=1)),
     *     @OA\RequestBody(required=true, @OA\JsonContent(ref="#/components/schemas/UpdateProductTagRequest")),
     *     @OA\Response(
     *         response=200,
     *         description="Cập nhật thành công",
     *         @OA\JsonContent(@OA\Property(property="data", ref="#/components/schemas/ProductTag"))
     *     ),
     *     @OA\Response(response=404, description="Không tìm thấy")
     * )
     */
    public function update(UpdateProductTagRequest $request, $id)
    {
        $model = $this->ProductTagService->update($id, $request->all());
        if (!$model) {
            return response()->json(['message' => 'Not found'], 404);
        }

        return response()->json(['data' => new ProductTagResource($model)], 200);
    }

    /**
     * @OA\Delete(
     *     path="/api/product-tags/{id}",
     *     summary="Xóa ProductTag",
     *     tags={"ProductTag"},
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
        $deleted = $this->ProductTagService->destroy($id);
        return response()->json(['success' => (bool) $deleted], 200);
    }
}