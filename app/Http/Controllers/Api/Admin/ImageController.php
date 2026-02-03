<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Image\StoreImageRequest;
use App\Http\Requests\Image\UpdateImageRequest;
use App\Http\Resources\ImageResource;
use App\Services\ImageService;
use Illuminate\Http\Request;

/**
 * @OA\Tag(
 *     name="Image",
 *     description="Quản lý hình ảnh"
 * )
 */
class ImageController extends Controller
{
    protected ImageService $imageService;

    public function __construct(ImageService $imageService)
    {
        $this->imageService = $imageService;
    }

    /**
     * @OA\Get(
     *     path="/api/images",
     *     summary="Danh sách image (paging)",
     *     tags={"Image"},
     *     @OA\Parameter(name="page", in="query", required=false, @OA\Schema(type="integer", example=1)),
     *     @OA\Parameter(name="items_per_page", in="query", required=false, @OA\Schema(type="integer", example=10)),
     *     @OA\Response(
     *         response=200,
     *         description="Danh sách image",
     *         @OA\JsonContent(
     *             @OA\Property(property="items", type="array", @OA\Items(ref="#/components/schemas/Image")),
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
        $result = $this->imageService->all($request->all());

        return response()->json([
            'items' => ImageResource::collection(collect($result['items'] ?? [])),
            'paginate' => $result['paginate'] ?? null,
        ], 200);
    }

    /**
     * @OA\Get(
     *     path="/api/images/search",
     *     summary="Tìm kiếm image (paging)",
     *     tags={"Image"},
     *     @OA\Parameter(name="keyword", in="query", required=false, @OA\Schema(type="string", example="http")),
     *     @OA\Parameter(name="page", in="query", required=false, @OA\Schema(type="integer", example=1)),
     *     @OA\Parameter(name="items_per_page", in="query", required=false, @OA\Schema(type="integer", example=10)),
     *     @OA\Response(
     *         response=200,
     *         description="Danh sách image",
     *         @OA\JsonContent(
     *             @OA\Property(property="items", type="array", @OA\Items(ref="#/components/schemas/Image")),
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
        $result = $this->imageService->search($request->all());

        return response()->json([
            'items' => ImageResource::collection(collect($result['items'] ?? [])),
            'paginate' => $result['paginate'] ?? null,
        ], 200);
    }

    /**
     * @OA\Get(
     *     path="/api/images/{id}",
     *     summary="Chi tiết image",
     *     tags={"Image"},
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer", example=1)),
     *     @OA\Response(response=200, description="Chi tiết image", @OA\JsonContent(ref="#/components/schemas/Image")),
     *     @OA\Response(response=404, description="Không tìm thấy")
     * )
     */
    public function show($id)
    {
        $image = $this->imageService->show($id);
        if (!$image) {
            return response()->json(['message' => 'Not found'], 404);
        }

        return response()->json(new ImageResource($image), 200);
    }

    /**
     * @OA\Post(
     *     path="/api/images",
     *     summary="Tạo image",
     *     tags={"Image"},
     *     @OA\RequestBody(required=true, @OA\JsonContent(ref="#/components/schemas/StoreImageRequest")),
     *     @OA\Response(
     *         response=201,
     *         description="Tạo thành công",
     *         @OA\JsonContent(@OA\Property(property="data", ref="#/components/schemas/Image"))
     *     )
     * )
     */
    public function store(StoreImageRequest $request)
    {
        $image = $this->imageService->store($request->only(['url']));
        return response()->json(['data' => new ImageResource($image)], 201);
    }

    /**
     * @OA\Put(
     *     path="/api/images/{id}",
     *     summary="Cập nhật image",
     *     tags={"Image"},
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer", example=1)),
     *     @OA\RequestBody(required=true, @OA\JsonContent(ref="#/components/schemas/UpdateImageRequest")),
     *     @OA\Response(
     *         response=200,
     *         description="Cập nhật thành công",
     *         @OA\JsonContent(@OA\Property(property="data", ref="#/components/schemas/Image"))
     *     ),
     *     @OA\Response(response=404, description="Không tìm thấy")
     * )
     */
    public function update(UpdateImageRequest $request, $id)
    {
        $image = $this->imageService->update($id, $request->only(['url']));
        if (!$image) {
            return response()->json(['message' => 'Not found'], 404);
        }

        return response()->json(['data' => new ImageResource($image)], 200);
    }

    /**
     * @OA\Delete(
     *     path="/api/images/{id}",
     *     summary="Xóa image",
     *     tags={"Image"},
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
        $deleted = $this->imageService->destroy($id);
        return response()->json(['success' => (bool) $deleted], 200);
    }
}
