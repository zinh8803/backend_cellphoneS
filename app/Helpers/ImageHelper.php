<?php

namespace App\Helpers;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ImageHelper
{
    /**
     * Upload image to Cloudinary or fallback to local storage
     *
     * @param UploadedFile $file
     * @param string $folder
     * @return array{url: string, public_id: string|null}|null
     */
    public static function uploadImage(UploadedFile $file, string $folder = 'uploads')
    {
        if (!$file || !$file->isValid()) {
            return null;
        }

        try {
            $cloudinary = app('cloudinary');

            $uploadOptions = [
                'folder' => $folder,
                'resource_type' => 'image',
            ];

            $uploadResult = $cloudinary->uploadApi()->upload(
                $file->getRealPath(),
                $uploadOptions
            );

            // Log::info('Image uploaded to Cloudinary', [
            //     'file' => $file->getClientOriginalName(),
            //     'url' => $uploadResult['secure_url']
            // ]);

            return [
                'url' => $uploadResult['secure_url'] ?? '',
                'public_id' => $uploadResult['public_id'] ?? null,
            ];
        } catch (\Exception $e) {
            Log::error('Cloudinary upload failed, fallback to local storage', [
                'error' => $e->getMessage()
            ]);

            // Fallback: lưu vào storage local
            $path = $file->store($folder, 'public');
            return [
                'url' => $path,
                'public_id' => null,
            ];
        }
    }

    /**
     * Delete image from Cloudinary by public_id
     *
     * @param string|null $publicId
     * @return bool
     */
    public static function deleteImage(?string $publicId): bool
    {
        if (empty($publicId)) {
            return false;
        }

        try {
            $cloudinary = app('cloudinary');
            $cloudinary->uploadApi()->destroy($publicId, [
                'resource_type' => 'image',
            ]);

            return true;
        } catch (\Exception $e) {
            Log::error('Cloudinary delete failed', [
                'public_id' => $publicId,
                'error' => $e->getMessage(),
            ]);

            return false;
        }
    }
}
