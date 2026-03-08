<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Attribute\StoreAttributeRequest;
use App\Http\Requests\Attribute\UpdateAttributeRequest;
use App\Http\Resources\AttributeResource;
use App\Services\AttributeService;
use Illuminate\Http\Request;

/**
 * @OA\Tag(
 *     name="Attribute",
 *     description="Quản lý attribute"
 * )
 */
class AttributeController extends Controller
{
    protected AttributeService $attributeService;

    public function __construct(AttributeService $attributeService)
    {
        $this->attributeService = $attributeService;
    }

    /**
     * @OA\Get(
     *     path="/api/attributes",
     *     summary="Danh sách attribute (paging)",
     *     tags={"Attribute"},
     *     @OA\Parameter(name="page", in="query", required=false, @OA\Schema(type="integer", example=1)),
     *     @OA\Parameter(name="items_per_page", in="query", required=false, @OA\Schema(type="integer", example=10)),
     *     @OA\Response(
     *         response=200,
     *         description="Danh sách attribute",
     *         @OA\JsonContent(
     *             @OA\Property(property="items", type="array", @OA\Items(ref="#/components/schemas/Attribute")),
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
        $result = $this->attributeService->all($request->all());

        return response()->json([
            'items' => AttributeResource::collection(collect($result['items'] ?? [])),
            'paginate' => $result['paginate'] ?? null,
        ], 200);
    }

    /**
     * @OA\Get(
     *     path="/api/attributes/search",
     *     summary="Tìm kiếm attribute (paging)",
     *     tags={"Attribute"},
     *     @OA\Parameter(name="keyword", in="query", required=false, @OA\Schema(type="string", example="Color")),
     *     @OA\Parameter(name="page", in="query", required=false, @OA\Schema(type="integer", example=1)),
     *     @OA\Parameter(name="items_per_page", in="query", required=false, @OA\Schema(type="integer", example=10)),
     *     @OA\Response(
     *         response=200,
     *         description="Danh sách attribute",
     *         @OA\JsonContent(
     *             @OA\Property(property="items", type="array", @OA\Items(ref="#/components/schemas/Attribute")),
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
        $result = $this->attributeService->search($request->all());

        return response()->json([
            'items' => AttributeResource::collection(collect($result['items'] ?? [])),
            'paginate' => $result['paginate'] ?? null,
        ], 200);
    }

    /**
     * @OA\Get(
     *     path="/api/attributes/{id}",
     *     summary="Chi tiết attribute",
     *     tags={"Attribute"},
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer", example=1)),
     *     @OA\Response(response=200, description="Chi tiết attribute", @OA\JsonContent(ref="#/components/schemas/Attribute")),
     *     @OA\Response(response=404, description="Không tìm thấy")
     * )
     */
    public function show($id)
    {
        $attribute = $this->attributeService->show($id);
        if (!$attribute) {
            return response()->json(['message' => 'Not found'], 404);
        }

        return response()->json(new AttributeResource($attribute), 200);
    }

    /**
     * @OA\Post(
     *     path="/api/attributes",
     *     summary="Tạo attribute",
     *     tags={"Attribute"},
     *     @OA\RequestBody(required=true, @OA\JsonContent(ref="#/components/schemas/StoreAttributeRequest")),
     *     @OA\Response(
     *         response=201,
     *         description="Tạo thành công",
     *         @OA\JsonContent(@OA\Property(property="data", ref="#/components/schemas/Attribute"))
     *     )
     * )
     */
    public function store(StoreAttributeRequest $request)
    {
        $attribute = $this->attributeService->store($request->only(['name']));
        return response()->json(['data' => new AttributeResource($attribute)], 201);
    }

    /**
     * @OA\Put(
     *     path="/api/attributes/{id}",
     *     summary="Cập nhật attribute",
     *     tags={"Attribute"},
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer", example=1)),
     *     @OA\RequestBody(required=true, @OA\JsonContent(ref="#/components/schemas/UpdateAttributeRequest")),
     *     @OA\Response(
     *         response=200,
     *         description="Cập nhật thành công",
     *         @OA\JsonContent(@OA\Property(property="data", ref="#/components/schemas/Attribute"))
     *     ),
     *     @OA\Response(response=404, description="Không tìm thấy")
     * )
     */
    public function update(UpdateAttributeRequest $request, $id)
    {
        $attribute = $this->attributeService->update($id, $request->only(['name']));
        if (!$attribute) {
            return response()->json(['message' => 'Not found'], 404);
        }

        return response()->json(['data' => new AttributeResource($attribute)], 200);
    }

    /**
     * @OA\Delete(
     *     path="/api/attributes/{id}",
     *     summary="Xóa attribute",
     *     tags={"Attribute"},
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
        $deleted = $this->attributeService->destroy($id);
        return response()->json(['success' => (bool) $deleted], 200);
    }
}
