<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserAddress\StoreUserAddressRequest;
use App\Http\Requests\UserAddress\UpdateUserAddressRequest;
use App\Http\Resources\UserAddressResource;
use App\Services\UserAddressService;
use Illuminate\Http\Request;

/**
 * @OA\Tag(
 *     name="UserAddress",
 *     description="CRUD UserAddress"
 * )
 */
class UserAddressController extends Controller
{
    protected UserAddressService $UserAddressService;

    public function __construct(UserAddressService $UserAddressService)
    {
        $this->UserAddressService = $UserAddressService;
    }

    /**
     * @OA\Get(
     *     path="/api/user-addresses",
     *     summary="Danh sách UserAddress (paging)",
     *     tags={"UserAddress"},
     *     @OA\Parameter(name="page", in="query", required=false, @OA\Schema(type="integer", example=1)),
     *     @OA\Parameter(name="items_per_page", in="query", required=false, @OA\Schema(type="integer", example=10)),
     *     @OA\Response(
     *         response=200,
     *         description="Danh sách UserAddress",
     *         @OA\JsonContent(
     *             @OA\Property(property="items", type="array", @OA\Items(ref="#/components/schemas/UserAddress")),
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
        $result = $this->UserAddressService->all($request->all());

        return response()->json([
            'items' => UserAddressResource::collection(collect($result['items'] ?? [])),
            'paginate' => $result['paginate'] ?? null,
        ], 200);
    }

    /**
     * @OA\Get(
     *     path="/api/user-addresses/search",
     *     summary="Tìm kiếm UserAddress (paging)",
     *     tags={"UserAddress"},
     *     @OA\Parameter(name="keyword", in="query", required=false, @OA\Schema(type="string")),
     *     @OA\Parameter(name="page", in="query", required=false, @OA\Schema(type="integer", example=1)),
     *     @OA\Parameter(name="items_per_page", in="query", required=false, @OA\Schema(type="integer", example=10)),
     *     @OA\Response(
     *         response=200,
     *         description="Danh sách UserAddress",
     *         @OA\JsonContent(
     *             @OA\Property(property="items", type="array", @OA\Items(ref="#/components/schemas/UserAddress")),
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
        $result = $this->UserAddressService->search($request->all());

        return response()->json([
            'items' => UserAddressResource::collection(collect($result['items'] ?? [])),
            'paginate' => $result['paginate'] ?? null,
        ], 200);
    }

    /**
     * @OA\Get(
     *     path="/api/user-addresses/{id}",
     *     summary="Chi tiết UserAddress",
     *     tags={"UserAddress"},
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer", example=1)),
     *     @OA\Response(response=200, description="Chi tiết UserAddress", @OA\JsonContent(ref="#/components/schemas/UserAddress")),
     *     @OA\Response(response=404, description="Không tìm thấy")
     * )
     */
    public function show($id)
    {
        $model = $this->UserAddressService->show($id);
        if (!$model) {
            return response()->json(['message' => 'Not found'], 404);
        }

        return response()->json(new UserAddressResource($model), 200);
    }

    /**
     * @OA\Post(
     *     path="/api/user-addresses",
     *     summary="Tạo UserAddress",
     *     tags={"UserAddress"},
     *     @OA\RequestBody(required=true, @OA\JsonContent(ref="#/components/schemas/StoreUserAddressRequest")),
     *     @OA\Response(
     *         response=201,
     *         description="Tạo thành công",
     *         @OA\JsonContent(@OA\Property(property="data", ref="#/components/schemas/UserAddress"))
     *     )
     * )
     */
    public function store(StoreUserAddressRequest $request)
    {
        $model = $this->UserAddressService->store($request->all());
        return response()->json(['data' => new UserAddressResource($model)], 201);
    }

    /**
     * @OA\Put(
     *     path="/api/user-addresses/{id}",
     *     summary="Cập nhật UserAddress",
     *     tags={"UserAddress"},
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer", example=1)),
     *     @OA\RequestBody(required=true, @OA\JsonContent(ref="#/components/schemas/UpdateUserAddressRequest")),
     *     @OA\Response(
     *         response=200,
     *         description="Cập nhật thành công",
     *         @OA\JsonContent(@OA\Property(property="data", ref="#/components/schemas/UserAddress"))
     *     ),
     *     @OA\Response(response=404, description="Không tìm thấy")
     * )
     */
    public function update(UpdateUserAddressRequest $request, $id)
    {
        $model = $this->UserAddressService->update($id, $request->all());
        if (!$model) {
            return response()->json(['message' => 'Not found'], 404);
        }

        return response()->json(['data' => new UserAddressResource($model)], 200);
    }

    /**
     * @OA\Delete(
     *     path="/api/user-addresses/{id}",
     *     summary="Xóa UserAddress",
     *     tags={"UserAddress"},
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
        $deleted = $this->UserAddressService->destroy($id);
        return response()->json(['success' => (bool) $deleted], 200);
    }
}
