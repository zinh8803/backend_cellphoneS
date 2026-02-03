<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Branch\StoreBranchRequest;
use App\Http\Requests\Branch\UpdateBranchRequest;
use App\Http\Resources\BranchResource;
use App\Services\BranchService;
use Illuminate\Http\Request;

/**
 * @OA\Tag(
 *     name="Branch",
 *     description="CRUD Branch"
 * )
 */
class BranchController extends Controller
{
    protected BranchService $BranchService;

    public function __construct(BranchService $BranchService)
    {
        $this->BranchService = $BranchService;
    }

    /**
     * @OA\Get(
     *     path="/api/branches",
     *     summary="Danh sách Branch (paging)",
     *     tags={"Branch"},
     *     @OA\Parameter(name="page", in="query", required=false, @OA\Schema(type="integer", example=1)),
     *     @OA\Parameter(name="items_per_page", in="query", required=false, @OA\Schema(type="integer", example=10)),
     *     @OA\Response(
     *         response=200,
     *         description="Danh sách Branch",
     *         @OA\JsonContent(
     *             @OA\Property(property="items", type="array", @OA\Items(ref="#/components/schemas/Branch")),
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
        $result = $this->BranchService->all($request->all());

        return response()->json([
            'items' => BranchResource::collection(collect($result['items'] ?? [])),
            'paginate' => $result['paginate'] ?? null,
        ], 200);
    }

    /**
     * @OA\Get(
     *     path="/api/branches/search",
     *     summary="Tìm kiếm Branch (paging)",
     *     tags={"Branch"},
     *     @OA\Parameter(name="keyword", in="query", required=false, @OA\Schema(type="string")),
     *     @OA\Parameter(name="page", in="query", required=false, @OA\Schema(type="integer", example=1)),
     *     @OA\Parameter(name="items_per_page", in="query", required=false, @OA\Schema(type="integer", example=10)),
     *     @OA\Response(
     *         response=200,
     *         description="Danh sách Branch",
     *         @OA\JsonContent(
     *             @OA\Property(property="items", type="array", @OA\Items(ref="#/components/schemas/Branch")),
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
        $result = $this->BranchService->search($request->all());

        return response()->json([
            'items' => BranchResource::collection(collect($result['items'] ?? [])),
            'paginate' => $result['paginate'] ?? null,
        ], 200);
    }

    /**
     * @OA\Get(
     *     path="/api/branches/{id}",
     *     summary="Chi tiết Branch",
     *     tags={"Branch"},
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer", example=1)),
     *     @OA\Response(response=200, description="Chi tiết Branch", @OA\JsonContent(ref="#/components/schemas/Branch")),
     *     @OA\Response(response=404, description="Không tìm thấy")
     * )
     */
    public function show($id)
    {
        $model = $this->BranchService->show($id);
        if (!$model) {
            return response()->json(['message' => 'Not found'], 404);
        }

        return response()->json(new BranchResource($model), 200);
    }

    /**
     * @OA\Post(
     *     path="/api/branches",
     *     summary="Tạo Branch",
     *     tags={"Branch"},
     *     @OA\RequestBody(required=true, @OA\JsonContent(ref="#/components/schemas/StoreBranchRequest")),
     *     @OA\Response(
     *         response=201,
     *         description="Tạo thành công",
     *         @OA\JsonContent(@OA\Property(property="data", ref="#/components/schemas/Branch"))
     *     )
     * )
     */
    public function store(StoreBranchRequest $request)
    {
        $model = $this->BranchService->store($request->all());
        return response()->json(['data' => new BranchResource($model)], 201);
    }

    /**
     * @OA\Put(
     *     path="/api/branches/{id}",
     *     summary="Cập nhật Branch",
     *     tags={"Branch"},
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer", example=1)),
     *     @OA\RequestBody(required=true, @OA\JsonContent(ref="#/components/schemas/UpdateBranchRequest")),
     *     @OA\Response(
     *         response=200,
     *         description="Cập nhật thành công",
     *         @OA\JsonContent(@OA\Property(property="data", ref="#/components/schemas/Branch"))
     *     ),
     *     @OA\Response(response=404, description="Không tìm thấy")
     * )
     */
    public function update(UpdateBranchRequest $request, $id)
    {
        $model = $this->BranchService->update($id, $request->all());
        if (!$model) {
            return response()->json(['message' => 'Not found'], 404);
        }

        return response()->json(['data' => new BranchResource($model)], 200);
    }

    /**
     * @OA\Delete(
     *     path="/api/branches/{id}",
     *     summary="Xóa Branch",
     *     tags={"Branch"},
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
        $deleted = $this->BranchService->destroy($id);
        return response()->json(['success' => (bool) $deleted], 200);
    }
}