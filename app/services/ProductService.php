<?php

namespace App\Services;

use App\Models\Image;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use App\Repositories\ProductRepository;

class ProductService
{
    protected ProductRepository $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function all($params = [])
    {
        return $this->productRepository->all($params);
    }

    public function search($params = [])
    {
        return $this->productRepository->search($params);
    }

    public function show($id)
    {
        return $this->productRepository->show($id);
    }

    public function store(array $data)
    {
        return DB::transaction(function () use ($data) {
            /** @var Product $product */
            $product = $this->productRepository->store(collect($data)->only([
                'name',
                'slug',
                'description',
                'category_id',
                'brand_id',
            ])->toArray());

            $this->syncTagsAndImages($product, $data);

            return $this->productRepository->show($product->id);
        });
    }

    public function update($id, array $data = [])
    {
        return DB::transaction(function () use ($id, $data) {
            $product = $this->productRepository->update($id, collect($data)->only([
                'name',
                'slug',
                'description',
                'category_id',
                'brand_id',
            ])->toArray());

            if (!$product) {
                return null;
            }

            $this->syncTagsAndImages($product, $data);

            return $this->productRepository->show($product->id);
        });
    }

    public function destroy($id)
    {
        return $this->productRepository->destroy($id);
    }

    private function syncTagsAndImages(Product $product, array $data): void
    {
        if (array_key_exists('tag_ids', $data) && is_array($data['tag_ids'])) {
            $product->productTags()->delete();
            foreach ($data['tag_ids'] as $tagId) {
                if (!empty($tagId)) {
                    $product->productTags()->create(['tag_id' => $tagId]);
                }
            }
        }

        // Support two formats:
        // 1) image_ids: [1,2]
        // 2) images: [{"id":1,"is_primary":true}] or [{"url":"http...","is_primary":true}]
        if (array_key_exists('image_ids', $data) && is_array($data['image_ids'])) {
            $product->productImages()->delete();
            foreach ($data['image_ids'] as $index => $imageId) {
                if (!empty($imageId)) {
                    $product->productImages()->create([
                        'image_id' => $imageId,
                        'is_primary' => $index === 0,
                    ]);
                }
            }
        }

        if (array_key_exists('images', $data) && is_array($data['images'])) {
            $product->productImages()->delete();

            foreach ($data['images'] as $index => $img) {
                if (!is_array($img)) {
                    continue;
                }

                $imageId = $img['id'] ?? null;
                $url = $img['url'] ?? null;

                if (empty($imageId) && !empty($url)) {
                    $imageId = Image::query()->create(['url' => $url])->id;
                }

                if (!empty($imageId)) {
                    $product->productImages()->create([
                        'image_id' => $imageId,
                        'is_primary' => (bool) ($img['is_primary'] ?? ($index === 0)),
                    ]);
                }
            }
        }
    }
}
