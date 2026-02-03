<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Employee\StoreEmployeeRequest;
use App\Http\Requests\Employee\UpdateEmployeeRequest;
use App\Http\Resources\EmployeeResource;
use App\Services\EmployeeService;
use Illuminate\Http\Request;

/**
 * @OA\Tag(
 *     name="Employee",
 *     description="CRUD Employee"
 * )
 */
class EmployeeController extends Controller
{
    protected EmployeeService $EmployeeService;

    public function __construct(EmployeeService $EmployeeService)
    {
        $this->EmployeeService = $EmployeeService;
    }

    /**
     * @OA\Get(
     *     path="/api/employees",
     *     summary="Danh sách Employee (paging)",
     *     tags={"Employee"},
     *     @OA\Parameter(name="page", in="query", required=false, @OA\Schema(type="integer", example=1)),
     *     @OA\Parameter(name="items_per_page", in="query", required=false, @OA\Schema(type="integer", example=10)),
     *     @OA\Response(
     *         response=200,
     *         description="Danh sách Employee",
     *         @OA\JsonContent(
     *             @OA\Property(property="items", type="array", @OA\Items(ref="#/components/schemas/Employee")),
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
        $result = $this->EmployeeService->all($request->all());

        return response()->json([
            'items' => EmployeeResource::collection(collect($result['items'] ?? [])),
            'paginate' => $result['paginate'] ?? null,
        ], 200);
    }

    /**
     * @OA\Get(
     *     path="/api/employees/search",
     *     summary="Tìm kiếm Employee (paging)",
     *     tags={"Employee"},
     *     @OA\Parameter(name="keyword", in="query", required=false, @OA\Schema(type="string")),
     *     @OA\Parameter(name="page", in="query", required=false, @OA\Schema(type="integer", example=1)),
     *     @OA\Parameter(name="items_per_page", in="query", required=false, @OA\Schema(type="integer", example=10)),
     *     @OA\Response(
     *         response=200,
     *         description="Danh sách Employee",
     *         @OA\JsonContent(
     *             @OA\Property(property="items", type="array", @OA\Items(ref="#/components/schemas/Employee")),
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
        $result = $this->EmployeeService->search($request->all());

        return response()->json([
            'items' => EmployeeResource::collection(collect($result['items'] ?? [])),
            'paginate' => $result['paginate'] ?? null,
        ], 200);
    }

    /**
     * @OA\Get(
     *     path="/api/employees/{id}",
     *     summary="Chi tiết Employee",
     *     tags={"Employee"},
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer", example=1)),
     *     @OA\Response(response=200, description="Chi tiết Employee", @OA\JsonContent(ref="#/components/schemas/Employee")),
     *     @OA\Response(response=404, description="Không tìm thấy")
     * )
     */
    public function show($id)
    {
        $model = $this->EmployeeService->show($id);
        if (!$model) {
            return response()->json(['message' => 'Not found'], 404);
        }

        return response()->json(new EmployeeResource($model), 200);
    }

    /**
     * @OA\Post(
     *     path="/api/employees",
     *     summary="Tạo Employee",
     *     tags={"Employee"},
     *     @OA\RequestBody(required=true, @OA\JsonContent(ref="#/components/schemas/StoreEmployeeRequest")),
     *     @OA\Response(
     *         response=201,
     *         description="Tạo thành công",
     *         @OA\JsonContent(@OA\Property(property="data", ref="#/components/schemas/Employee"))
     *     )
     * )
     */
    public function store(StoreEmployeeRequest $request)
    {
        $model = $this->EmployeeService->store($request->all());
        return response()->json(['data' => new EmployeeResource($model)], 201);
    }

    /**
     * @OA\Put(
     *     path="/api/employees/{id}",
     *     summary="Cập nhật Employee",
     *     tags={"Employee"},
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer", example=1)),
     *     @OA\RequestBody(required=true, @OA\JsonContent(ref="#/components/schemas/UpdateEmployeeRequest")),
     *     @OA\Response(
     *         response=200,
     *         description="Cập nhật thành công",
     *         @OA\JsonContent(@OA\Property(property="data", ref="#/components/schemas/Employee"))
     *     ),
     *     @OA\Response(response=404, description="Không tìm thấy")
     * )
     */
    public function update(UpdateEmployeeRequest $request, $id)
    {
        $model = $this->EmployeeService->update($id, $request->all());
        if (!$model) {
            return response()->json(['message' => 'Not found'], 404);
        }

        return response()->json(['data' => new EmployeeResource($model)], 200);
    }

    /**
     * @OA\Delete(
     *     path="/api/employees/{id}",
     *     summary="Xóa Employee",
     *     tags={"Employee"},
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
        $deleted = $this->EmployeeService->destroy($id);
        return response()->json(['success' => (bool) $deleted], 200);
    }
}