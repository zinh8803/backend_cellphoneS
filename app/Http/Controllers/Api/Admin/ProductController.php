<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Product\StoreProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;
use App\Http\Resources\ProductResource;
use App\Services\ProductService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class ProductController extends Controller
{
    protected ProductService $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    /**
     * @OA\Tag(
     *     name="Product",
     *     description="Quản lý sản phẩm"
     * )
     */

    /**
     * @OA\Get(
     *     path="/api/products",
     *     summary="Danh sách sản phẩm (paging)",
     *     tags={"Product"},
     *     @OA\Parameter(name="keyword", in="query", required=false, @OA\Schema(type="string")),
     *     @OA\Parameter(name="brand_id", in="query", required=false, @OA\Schema(type="integer")),
     *     @OA\Parameter(name="category_id", in="query", required=false, @OA\Schema(type="integer")),
     *     @OA\Parameter(name="tag_id", in="query", required=false, @OA\Schema(type="integer")),
     *     @OA\Parameter(name="page", in="query", required=false, @OA\Schema(type="integer", example=1)),
     *     @OA\Parameter(name="items_per_page", in="query", required=false, @OA\Schema(type="integer", example=10)),
     *     @OA\Response(
     *         response=200,
     *         description="Danh sách sản phẩm",
     *         @OA\JsonContent(
     *             @OA\Property(property="items", type="array", @OA\Items(ref="#/components/schemas/Product")),
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
        // Reuse search() so filters work on index too
        $result = $this->productService->search($request->all());

        return response()->json([
            'items' => ProductResource::collection(collect($result['items'] ?? [])),
            'paginate' => $result['paginate'] ?? null,
        ], 200);
    }

    /**
     * @OA\Get(
     *     path="/api/products/search",
     *     summary="Tìm kiếm sản phẩm (paging)",
     *     tags={"Product"},
     *     @OA\Parameter(name="keyword", in="query", required=false, @OA\Schema(type="string")),
     *     @OA\Parameter(name="brand_id", in="query", required=false, @OA\Schema(type="integer")),
     *     @OA\Parameter(name="category_id", in="query", required=false, @OA\Schema(type="integer")),
     *     @OA\Parameter(name="tag_id", in="query", required=false, @OA\Schema(type="integer")),
     *     @OA\Parameter(name="page", in="query", required=false, @OA\Schema(type="integer", example=1)),
     *     @OA\Parameter(name="items_per_page", in="query", required=false, @OA\Schema(type="integer", example=10)),
     *     @OA\Response(
     *         response=200,
     *         description="Danh sách sản phẩm",
     *         @OA\JsonContent(
     *             @OA\Property(property="items", type="array", @OA\Items(ref="#/components/schemas/Product")),
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
        $result = $this->productService->search($request->all());

        return response()->json([
            'items' => ProductResource::collection(collect($result['items'] ?? [])),
            'paginate' => $result['paginate'] ?? null,
        ], 200);
    }

    /**
     * @OA\Get(
     *     path="/api/products/{id}",
     *     summary="Chi tiết sản phẩm",
     *     tags={"Product"},
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer", example=1)),
     *     @OA\Response(response=200, description="Chi tiết sản phẩm", @OA\JsonContent(ref="#/components/schemas/Product")),
     *     @OA\Response(response=404, description="Không tìm thấy")
     * )
     */
    public function show($id)
    {
        $product = $this->productService->show($id);
        if (!$product) {
            return response()->json(['message' => 'Not found'], 404);
        }

        return response()->json(new ProductResource($product), 200);
    }

    /**
     * @OA\Post(
     *     path="/api/products",
     *     summary="Tạo sản phẩm",
     *     tags={"Product"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(ref="#/components/schemas/StoreProductRequest")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Tạo thành công",
     *         @OA\JsonContent(@OA\Property(property="data", ref="#/components/schemas/Product"))
     *     )
     * )
     */
    public function store(StoreProductRequest $request)
    {
        $payload = array_merge($request->except('image_files'), [
            'image_files' => $this->extractImageFiles($request),
        ]);

        $product = $this->productService->store($payload);
        return response()->json(['data' => new ProductResource($product)], 201);
    }

    /**
     * @OA\Post(
     *     path="/api/products/{id}",
     *     summary="Cập nhật sản phẩm",
     *     tags={"Product"},
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer", example=1)),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(ref="#/components/schemas/UpdateProductRequest")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Cập nhật thành công",
     *         @OA\JsonContent(@OA\Property(property="data", ref="#/components/schemas/Product"))
     *     ),
     *     @OA\Response(response=404, description="Không tìm thấy")
     * )
     */
    public function update(UpdateProductRequest $request, $id)
    {
        $payload = array_merge($request->except('image_files'), [
            'image_files' => $this->extractImageFiles($request),
        ]);

        $product = $this->productService->update($id, $payload);
        if (!$product) {
            return response()->json(['message' => 'Not found'], 404);
        }

        return response()->json(['data' => new ProductResource($product)], 200);
    }

    /**
     * @OA\Delete(
     *     path="/api/products/{id}",
     *     summary="Xóa sản phẩm",
     *     tags={"Product"},
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
        $deleted = $this->productService->destroy($id);
        return response()->json(['success' => (bool) $deleted], 200);
    }

    private function extractImageFiles(Request $request): array
    {
        $allFiles = $request->allFiles();
        $imageFiles = [];
        $seen = [];

        $flatten = function ($value) use (&$flatten, &$imageFiles, &$seen): void {
            if ($value instanceof UploadedFile) {
                $objectId = spl_object_id($value);
                if (!isset($seen[$objectId])) {
                    $seen[$objectId] = true;
                    $imageFiles[] = $value;
                }
                return;
            }

            if (!is_array($value)) {
                return;
            }

            foreach ($value as $item) {
                $flatten($item);
            }
        };

        $flatten($request->file('image_files'));
        $flatten($request->file('image_files[]'));

        foreach ($allFiles as $key => $value) {
            if (str_starts_with((string) $key, 'image_files')) {
                $flatten($value);
            }
        }

        $fileNames = array_map(function ($file) {
            return $file instanceof UploadedFile ? $file->getClientOriginalName() : '';
        }, $imageFiles);

        $rawFileKeys = array_keys($allFiles);
        Log::info('ProductController image_files input', [
            'raw_keys' => $rawFileKeys,
            'count' => count($imageFiles),
            'files' => $fileNames,
        ]);

        return $imageFiles;
    }
}
