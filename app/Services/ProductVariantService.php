<?php

namespace App\Services;

use App\Models\Color;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Storage;
use App\Repositories\ProductVariantRepository;
use Illuminate\Support\Str;

class ProductVariantService
{
    protected ProductVariantRepository $ProductVariantRepository;

    public function __construct(ProductVariantRepository $ProductVariantRepository)
    {
        $this->ProductVariantRepository = $ProductVariantRepository;
    }

    public function all($params = [])
    {
        return $this->ProductVariantRepository->all($params);
    }

    public function search($params = [])
    {
        return $this->ProductVariantRepository->search($params);
    }

    public function show($id)
    {
        return $this->ProductVariantRepository->show($id);
    }

    public function store(array $data)
    {
        if (empty($data['sku'] ?? null)) {
            $data['sku'] = $this->buildSku(
                $data['product_id'] ?? null,
                $data['color_id'] ?? null,
                $data['storage_id'] ?? null
            );
        }

        return $this->ProductVariantRepository->store($data);
    }

    public function update($id, array $data = [])
    {
        $model = $this->ProductVariantRepository->show($id);
        if (!$model) {
            return null;
        }

        if (empty($data['sku'] ?? null)) {
            $productId = $data['product_id'] ?? $model->product_id;
            $colorId = $data['color_id'] ?? $model->color_id;
            $storageId = $data['storage_id'] ?? $model->storage_id;

            $data['sku'] = $this->buildSku($productId, $colorId, $storageId);
        }

        return $this->ProductVariantRepository->update($id, $data);
    }

    public function destroy($id)
    {
        return $this->ProductVariantRepository->destroy($id);
    }

    private function buildSku(?int $productId, ?int $colorId, ?int $storageId): string
    {
        $product = $productId ? Product::query()->find($productId) : null;
        $color = $colorId ? Color::query()->find($colorId) : null;
        $storage = $storageId ? Storage::query()->find($storageId) : null;

        $productCode = $this->normalizeCode($product->slug ?? null);
        if ($productCode === '') {
            $productCode = $productId ? 'P' . $productId : 'PRODUCT';
        }

        $colorCode = $this->normalizeCode($color->code ?? null);
        $storageCode = $this->normalizeCode($storage->label ?? null);

        if ($colorCode === '') {
            $colorCode = 'NA';
        }

        if ($storageCode === '') {
            $storageCode = 'NA';
        }

        $base = $productCode . '-' . $colorCode . '-' . $storageCode;

        for ($i = 0; $i < 5; $i++) {
            $random = Str::upper(Str::random(4));
            $sku = $base . '-' . $random;
            $exists = ProductVariant::query()->where('sku', $sku)->exists();
            if (!$exists) {
                return $sku;
            }
        }

        return $base . '-' . Str::upper(Str::random(4));
    }

    private function normalizeCode(?string $value): string
    {
        if ($value === null) {
            return '';
        }

        $upper = Str::upper($value);
        return preg_replace('/[^A-Z0-9]/', '', $upper) ?? '';
    }
}
