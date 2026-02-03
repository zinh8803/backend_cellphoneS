<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Review\StoreReviewRequest;
use App\Http\Requests\Review\UpdateReviewRequest;
use App\Http\Resources\ReviewResource;
use App\Services\ReviewService;
use Illuminate\Http\Request;

/**
 * @OA\Tag(
 *     name="Review",
 *     description="CRUD Review"
 * )
 */
class ReviewController extends Controller
{
    protected ReviewService $ReviewService;

    public function __construct(ReviewService $ReviewService)
    {
        $this->ReviewService = $ReviewService;
    }

    /**
     * @OA\Get(
     *     path="/api/reviews",
     *     summary="Danh sách Review (paging)",
     *     tags={"Review"},
     *     @OA\Parameter(name="page", in="query", required=false, @OA\Schema(type="integer", example=1)),
     *     @OA\Parameter(name="items_per_page", in="query", required=false, @OA\Schema(type="integer", example=10)),
     *     @OA\Response(
     *         response=200,
     *         description="Danh sách Review",
     *         @OA\JsonContent(
     *             @OA\Property(property="items", type="array", @OA\Items(ref="#/components/schemas/Review")),
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
        $result = $this->ReviewService->all($request->all());

        return response()->json([
            'items' => ReviewResource::collection(collect($result['items'] ?? [])),
            'paginate' => $result['paginate'] ?? null,
        ], 200);
    }

    /**
     * @OA\Get(
     *     path="/api/reviews/search",
     *     summary="Tìm kiếm Review (paging)",
     *     tags={"Review"},
     *     @OA\Parameter(name="keyword", in="query", required=false, @OA\Schema(type="string")),
     *     @OA\Parameter(name="page", in="query", required=false, @OA\Schema(type="integer", example=1)),
     *     @OA\Parameter(name="items_per_page", in="query", required=false, @OA\Schema(type="integer", example=10)),
     *     @OA\Response(
     *         response=200,
     *         description="Danh sách Review",
     *         @OA\JsonContent(
     *             @OA\Property(property="items", type="array", @OA\Items(ref="#/components/schemas/Review")),
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
        $result = $this->ReviewService->search($request->all());

        return response()->json([
            'items' => ReviewResource::collection(collect($result['items'] ?? [])),
            'paginate' => $result['paginate'] ?? null,
        ], 200);
    }

    /**
     * @OA\Get(
     *     path="/api/reviews/{id}",
     *     summary="Chi tiết Review",
     *     tags={"Review"},
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer", example=1)),
     *     @OA\Response(response=200, description="Chi tiết Review", @OA\JsonContent(ref="#/components/schemas/Review")),
     *     @OA\Response(response=404, description="Không tìm thấy")
     * )
     */
    public function show($id)
    {
        $model = $this->ReviewService->show($id);
        if (!$model) {
            return response()->json(['message' => 'Not found'], 404);
        }

        return response()->json(new ReviewResource($model), 200);
    }

    /**
     * @OA\Post(
     *     path="/api/reviews",
     *     summary="Tạo Review",
     *     tags={"Review"},
     *     @OA\RequestBody(required=true, @OA\JsonContent(ref="#/components/schemas/StoreReviewRequest")),
     *     @OA\Response(
     *         response=201,
     *         description="Tạo thành công",
     *         @OA\JsonContent(@OA\Property(property="data", ref="#/components/schemas/Review"))
     *     )
     * )
     */
    public function store(StoreReviewRequest $request)
    {
        $model = $this->ReviewService->store($request->all());
        return response()->json(['data' => new ReviewResource($model)], 201);
    }

    /**
     * @OA\Put(
     *     path="/api/reviews/{id}",
     *     summary="Cập nhật Review",
     *     tags={"Review"},
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer", example=1)),
     *     @OA\RequestBody(required=true, @OA\JsonContent(ref="#/components/schemas/UpdateReviewRequest")),
     *     @OA\Response(
     *         response=200,
     *         description="Cập nhật thành công",
     *         @OA\JsonContent(@OA\Property(property="data", ref="#/components/schemas/Review"))
     *     ),
     *     @OA\Response(response=404, description="Không tìm thấy")
     * )
     */
    public function update(UpdateReviewRequest $request, $id)
    {
        $model = $this->ReviewService->update($id, $request->all());
        if (!$model) {
            return response()->json(['message' => 'Not found'], 404);
        }

        return response()->json(['data' => new ReviewResource($model)], 200);
    }

    /**
     * @OA\Delete(
     *     path="/api/reviews/{id}",
     *     summary="Xóa Review",
     *     tags={"Review"},
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
        $deleted = $this->ReviewService->destroy($id);
        return response()->json(['success' => (bool) $deleted], 200);
    }
}