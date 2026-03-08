<?php

namespace App\Services;

use App\Helpers\ImageHelper;
use App\Models\Image;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Repositories\ProductRepository;
use Symfony\Component\HttpFoundation\File\UploadedFile;

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
        $product = $this->productRepository->show($id);
        if (!$product) {
            return false;
        }

        $this->deleteProductImagesFromCloudinary($product);

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

        if (array_key_exists('attributes', $data) && is_array($data['attributes'])) {
            $product->productAttributeValues()->delete();

            foreach ($data['attributes'] as $attribute) {
                $attributeId = $attribute['attribute_id'] ?? null;
                $value = $attribute['value'] ?? null;

                if (empty($attributeId) || !is_scalar($value) || (string) $value === '') {
                    continue;
                }

                $product->productAttributeValues()->create([
                    'attribute_id' => (int) $attributeId,
                    'value' => (string) $value,
                ]);
            }
        }

        // Support form-data image_files only: [UploadedFile, ...] (upload Cloudinary)
        if (array_key_exists('image_files', $data)) {
            $uploadedFiles = $this->extractUploadedFiles($data['image_files']);

            $validFiles = array_values(array_filter($uploadedFiles, function ($file) {
                return $file instanceof UploadedFile && $file->isValid();
            }));

            if (empty($validFiles)) {
                return;
            }

            $this->deleteProductImagesFromCloudinary($product);
            $product->productImages()->delete();

            $savedCount = 0;
            foreach ($validFiles as $file) {
                $uploadResult = ImageHelper::uploadImage($file, 'products');
                if (empty($uploadResult) || empty($uploadResult['url'])) {
                    continue;
                }

                $imageId = Image::query()->create([
                    'url' => $uploadResult['url'],
                    'public_id' => $uploadResult['public_id'] ?? null,
                ])->id;
                $product->productImages()->create([
                    'image_id' => $imageId,
                    'is_primary' => $savedCount === 0,
                ]);

                $savedCount++;
            }
        }
    }

    private function deleteProductImagesFromCloudinary(Product $product): void
    {
        $product->loadMissing('productImages.image');

        foreach ($product->productImages as $productImage) {
            $publicId = $productImage->image->public_id ?? null;
            if (!empty($publicId)) {
                ImageHelper::deleteImage($publicId);
            }
        }
    }

    private function extractUploadedFiles(mixed $files): array
    {
        if ($files instanceof UploadedFile) {
            return [$files];
        }

        if (!is_array($files)) {
            return [];
        }

        $result = [];
        array_walk_recursive($files, function ($file) use (&$result) {
            if ($file instanceof UploadedFile) {
                $result[] = $file;
            }
        });

        return $result;
    }
}
