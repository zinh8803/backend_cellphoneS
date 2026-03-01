<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Category\StoreCategoryRequest;
use App\Http\Requests\Category\UpdateCategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Services\CategoryService;
use Illuminate\Http\Request;

/**
 * @OA\Tag(
 *     name="Category",
 *     description="Quản lý danh mục"
 * )
 */
class CategoryController extends Controller
{
    protected CategoryService $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    /**
     * @OA\Get(
     *     path="/api/categories",
     *     summary="Danh sách category (paging)",
     *     tags={"Category"},
     *     @OA\Parameter(name="page", in="query", required=false, @OA\Schema(type="integer", example=1)),
     *     @OA\Parameter(name="items_per_page", in="query", required=false, @OA\Schema(type="integer", example=10)),
     *     @OA\Response(
     *         response=200,
     *         description="Danh sách category",
     *         @OA\JsonContent(
     *             @OA\Property(property="items", type="array", @OA\Items(ref="#/components/schemas/Category")),
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
        $result = $this->categoryService->all($request->all());

        return response()->json([
            'items' => CategoryResource::collection(collect($result['items'] ?? [])),
            'paginate' => $result['paginate'] ?? null,
        ], 200);
    }

    /**
     * @OA\Get(
     *     path="/api/categories/search",
     *     summary="Tìm kiếm category (paging)",
     *     tags={"Category"},
     *     @OA\Parameter(name="keyword", in="query", required=false, @OA\Schema(type="string", example="phone")),
     *     @OA\Parameter(name="page", in="query", required=false, @OA\Schema(type="integer", example=1)),
     *     @OA\Parameter(name="items_per_page", in="query", required=false, @OA\Schema(type="integer", example=10)),
     *     @OA\Response(
     *         response=200,
     *         description="Danh sách category",
     *         @OA\JsonContent(
     *             @OA\Property(property="items", type="array", @OA\Items(ref="#/components/schemas/Category")),
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
        $result = $this->categoryService->search($request->all());

        return response()->json([
            'items' => CategoryResource::collection(collect($result['items'] ?? [])),
            'paginate' => $result['paginate'] ?? null,
        ], 200);
    }

    /**
     * @OA\Get(
     *     path="/api/categories/{id}",
     *     summary="Chi tiết category",
     *     tags={"Category"},
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer", example=1)),
     *     @OA\Response(response=200, description="Chi tiết category", @OA\JsonContent(ref="#/components/schemas/Category")),
     *     @OA\Response(response=404, description="Không tìm thấy")
     * )
     */
    public function show($id)
    {
        $category = $this->categoryService->show($id);
        if (!$category) {
            return response()->json(['message' => 'Not found'], 404);
        }

        return response()->json(new CategoryResource($category), 200);
    }

    /**
     * @OA\Post(
     *     path="/api/categories",
     *     summary="Tạo category",
     *     tags={"Category"},
     *     @OA\RequestBody(required=true, @OA\JsonContent(ref="#/components/schemas/StoreCategoryRequest")),
     *     @OA\Response(
     *         response=201,
     *         description="Tạo thành công",
     *         @OA\JsonContent(@OA\Property(property="data", ref="#/components/schemas/Category"))
     *     )
     * )
     */
    public function store(StoreCategoryRequest $request)
    {
        $category = $this->categoryService->store($request->only(['name', 'slug', 'parent_id']));
        return response()->json(['data' => new CategoryResource($category)], 201);
    }

    /**
     * @OA\Put(
     *     path="/api/categories/{id}",
     *     summary="Cập nhật category",
     *     tags={"Category"},
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer", example=1)),
     *     @OA\RequestBody(required=true, @OA\JsonContent(ref="#/components/schemas/UpdateCategoryRequest")),
     *     @OA\Response(
     *         response=200,
     *         description="Cập nhật thành công",
     *         @OA\JsonContent(@OA\Property(property="data", ref="#/components/schemas/Category"))
     *     ),
     *     @OA\Response(response=404, description="Không tìm thấy")
     * )
     */
    public function update(UpdateCategoryRequest $request, $id)
    {
        $category = $this->categoryService->update($id, $request->only(['name', 'slug']));
        if (!$category) {
            return response()->json(['message' => 'Not found'], 404);
        }

        return response()->json(['data' => new CategoryResource($category)], 200);
    }

    /**
     * @OA\Delete(
     *     path="/api/categories/{id}",
     *     summary="Xóa category",
     *     tags={"Category"},
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
        $deleted = $this->categoryService->destroy($id);
        return response()->json(['success' => (bool) $deleted], 200);
    }
}
