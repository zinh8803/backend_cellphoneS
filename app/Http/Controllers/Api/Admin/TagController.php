<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Tag\StoreTagRequest;
use App\Http\Requests\Tag\UpdateTagRequest;
use App\Http\Resources\TagResource;
use App\Services\TagService;
use Illuminate\Http\Request;

/**
 * @OA\Tag(
 *     name="Tag",
 *     description="Quản lý tag"
 * )
 */
class TagController extends Controller
{
    protected TagService $tagService;

    public function __construct(TagService $tagService)
    {
        $this->tagService = $tagService;
    }

    /**
     * @OA\Get(
     *     path="/api/tags",
     *     summary="Danh sách tag (paging)",
     *     tags={"Tag"},
     *     @OA\Parameter(name="page", in="query", required=false, @OA\Schema(type="integer", example=1)),
     *     @OA\Parameter(name="items_per_page", in="query", required=false, @OA\Schema(type="integer", example=10)),
     *     @OA\Response(
     *         response=200,
     *         description="Danh sách tag",
     *         @OA\JsonContent(
     *             @OA\Property(property="items", type="array", @OA\Items(ref="#/components/schemas/Tag")),
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
        $result = $this->tagService->all($request->all());

        return response()->json([
            'items' => TagResource::collection(collect($result['items'] ?? [])),
            'paginate' => $result['paginate'] ?? null,
        ], 200);
    }

    /**
     * @OA\Get(
     *     path="/api/tags/search",
     *     summary="Tìm kiếm tag (paging)",
     *     tags={"Tag"},
     *     @OA\Parameter(name="keyword", in="query", required=false, @OA\Schema(type="string", example="hot")),
     *     @OA\Parameter(name="page", in="query", required=false, @OA\Schema(type="integer", example=1)),
     *     @OA\Parameter(name="items_per_page", in="query", required=false, @OA\Schema(type="integer", example=10)),
     *     @OA\Response(
     *         response=200,
     *         description="Danh sách tag",
     *         @OA\JsonContent(
     *             @OA\Property(property="items", type="array", @OA\Items(ref="#/components/schemas/Tag")),
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
        $result = $this->tagService->search($request->all());

        return response()->json([
            'items' => TagResource::collection(collect($result['items'] ?? [])),
            'paginate' => $result['paginate'] ?? null,
        ], 200);
    }

    /**
     * @OA\Get(
     *     path="/api/tags/{id}",
     *     summary="Chi tiết tag",
     *     tags={"Tag"},
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer", example=1)),
     *     @OA\Response(response=200, description="Chi tiết tag", @OA\JsonContent(ref="#/components/schemas/Tag")),
     *     @OA\Response(response=404, description="Không tìm thấy")
     * )
     */
    public function show($id)
    {
        $tag = $this->tagService->show($id);
        if (!$tag) {
            return response()->json(['message' => 'Not found'], 404);
        }

        return response()->json(new TagResource($tag), 200);
    }

    /**
     * @OA\Post(
     *     path="/api/tags",
     *     summary="Tạo tag",
     *     tags={"Tag"},
     *     @OA\RequestBody(required=true, @OA\JsonContent(ref="#/components/schemas/StoreTagRequest")),
     *     @OA\Response(
     *         response=201,
     *         description="Tạo thành công",
     *         @OA\JsonContent(@OA\Property(property="data", ref="#/components/schemas/Tag"))
     *     )
     * )
     */
    public function store(StoreTagRequest $request)
    {
        $tag = $this->tagService->store($request->only(['name', 'slug']));
        return response()->json(['data' => new TagResource($tag)], 201);
    }

    /**
     * @OA\Put(
     *     path="/api/tags/{id}",
     *     summary="Cập nhật tag",
     *     tags={"Tag"},
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer", example=1)),
     *     @OA\RequestBody(required=true, @OA\JsonContent(ref="#/components/schemas/UpdateTagRequest")),
     *     @OA\Response(
     *         response=200,
     *         description="Cập nhật thành công",
     *         @OA\JsonContent(@OA\Property(property="data", ref="#/components/schemas/Tag"))
     *     ),
     *     @OA\Response(response=404, description="Không tìm thấy")
     * )
     */
    public function update(UpdateTagRequest $request, $id)
    {
        $tag = $this->tagService->update($id, $request->only(['name', 'slug']));
        if (!$tag) {
            return response()->json(['message' => 'Not found'], 404);
        }

        return response()->json(['data' => new TagResource($tag)], 200);
    }

    /**
     * @OA\Delete(
     *     path="/api/tags/{id}",
     *     summary="Xóa tag",
     *     tags={"Tag"},
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
        $deleted = $this->tagService->destroy($id);
        return response()->json(['success' => (bool) $deleted], 200);
    }
}
