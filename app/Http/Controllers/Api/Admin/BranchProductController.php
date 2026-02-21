<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\BranchProduct\StoreBranchProductRequest;
use App\Http\Requests\BranchProduct\UpdateBranchProductRequest;
use App\Http\Resources\BranchProductResource;
use App\Services\BranchProductService;
use Illuminate\Container\Attributes\Log;
use Illuminate\Http\Request;

/**
 * @OA\Tag(
 *     name="BranchProduct",
 *     description="CRUD BranchProduct"
 * )
 */
class BranchProductController extends Controller
{
    protected BranchProductService $BranchProductService;

    public function __construct(BranchProductService $BranchProductService)
    {
        $this->BranchProductService = $BranchProductService;
    }

    /**
     * @OA\Get(
     *     path="/api/branch-products",
     *     summary="Danh sách BranchProduct (paging)",
     *     tags={"BranchProduct"},
     *     @OA\Parameter(name="page", in="query", required=false, @OA\Schema(type="integer", example=1)),
     *     @OA\Parameter(name="items_per_page", in="query", required=false, @OA\Schema(type="integer", example=10)),
     *     @OA\Response(
     *         response=200,
     *         description="Danh sách BranchProduct",
     *         @OA\JsonContent(
     *             @OA\Property(property="items", type="array", @OA\Items(ref="#/components/schemas/BranchProduct")),
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
        $result = $this->BranchProductService->all($request->all());

        return response()->json([
            'items' => BranchProductResource::collection(collect($result['items'] ?? [])),
            'paginate' => $result['paginate'] ?? null,
        ], 200);
    }

    /**
     * @OA\Get(
     *     path="/api/branch-products/search",
     *     summary="Tìm kiếm BranchProduct (paging)",
     *     tags={"BranchProduct"},
     *     @OA\Parameter(name="keyword", in="query", required=false, @OA\Schema(type="string")),
     *     @OA\Parameter(name="page", in="query", required=false, @OA\Schema(type="integer", example=1)),
     *     @OA\Parameter(name="items_per_page", in="query", required=false, @OA\Schema(type="integer", example=10)),
     *     @OA\Response(
     *         response=200,
     *         description="Danh sách BranchProduct",
     *         @OA\JsonContent(
     *             @OA\Property(property="items", type="array", @OA\Items(ref="#/components/schemas/BranchProduct")),
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
        $result = $this->BranchProductService->search($request->all());

        return response()->json([
            'items' => BranchProductResource::collection(collect($result['items'] ?? [])),
            'paginate' => $result['paginate'] ?? null,
        ], 200);
    }

    /**
     * @OA\Get(
     *     path="/api/branch-products/{id}",
     *     summary="Chi tiết BranchProduct",
     *     tags={"BranchProduct"},
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer", example=1)),
     *     @OA\Response(response=200, description="Chi tiết BranchProduct", @OA\JsonContent(ref="#/components/schemas/BranchProduct")),
     *     @OA\Response(response=404, description="Không tìm thấy")
     * )
     */
    public function show($id)
    {
        $model = $this->BranchProductService->show($id);
        if (!$model) {
            return response()->json(['message' => 'Not found'], 404);
        }

        return response()->json(new BranchProductResource($model), 200);
    }

    /**
     * @OA\Post(
     *     path="/api/branch-products",
     *     summary="Tạo BranchProduct",
     *     tags={"BranchProduct"},
     *     @OA\RequestBody(required=true, @OA\JsonContent(ref="#/components/schemas/StoreBranchProductRequest")),
     *     @OA\Response(
     *         response=201,
     *         description="Tạo thành công",
     *         @OA\JsonContent(@OA\Property(property="data", ref="#/components/schemas/BranchProduct"))
     *     )
     * )
     */
    public function store(StoreBranchProductRequest $request)
    {
        $model = $this->BranchProductService->store($request->validated());
        return response()->json(['data' => new BranchProductResource($model)], 201);
    }

    /**
     * @OA\Put(
     *     path="/api/branch-products/{id}",
     *     summary="Cập nhật BranchProduct",
     *     tags={"BranchProduct"},
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer", example=1)),
     *     @OA\RequestBody(required=true, @OA\JsonContent(ref="#/components/schemas/UpdateBranchProductRequest")),
     *     @OA\Response(
     *         response=200,
     *         description="Cập nhật thành công",
     *         @OA\JsonContent(@OA\Property(property="data", ref="#/components/schemas/BranchProduct"))
     *     ),
     *     @OA\Response(response=404, description="Không tìm thấy")
     * )
     */
    public function update(UpdateBranchProductRequest $request, $id)
    {
        $model = $this->BranchProductService->update($id, $request->validated());
        if (!$model) {
            return response()->json(['message' => 'Not found'], 404);
        }

        return response()->json(['data' => new BranchProductResource($model)], 200);
    }

    /**
     * @OA\Delete(
     *     path="/api/branch-products/{id}",
     *     summary="Xóa BranchProduct",
     *     tags={"BranchProduct"},
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
        $deleted = $this->BranchProductService->destroy($id);
        return response()->json(['success' => (bool) $deleted], 200);
    }
}
