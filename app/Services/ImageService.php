<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Laravel\Facades\Image;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class ImageService
{
    /**
     * Compress, resize, and store an uploaded image automatically.
     *
     * @param UploadedFile|TemporaryUploadedFile|string $file Uploaded file or path
     * @param string $directory Target storage folder (e.g., 'avatars', 'settings')
     * @param string $disk Storage disk (default: 'public')
     * @param int $maxWidth Max width/height dimension in pixels (default: 1200)
     * @param int $quality Compression quality 1-100 (default: 80)
     * @param string $format Target format: 'webp', 'jpg', 'png', etc. (default: 'webp')
     * @return string Relative storage path of the compressed image
     */
    public static function compressAndStore(
        mixed $file,
        string $directory = 'uploads',
        string $disk = 'public',
        int $maxWidth = 1200,
        int $quality = 80,
        string $format = 'webp'
    ): string {
        // If file is an SVG or ICO, bypass raster compression and store as-is
        $mime = self::detectMimeType($file);
        if (in_array($mime, ['image/svg+xml', 'image/x-icon', 'image/vnd.microsoft.icon'])) {
            return is_object($file) && method_exists($file, 'store')
                ? $file->store($directory, $disk)
                : self::storeRawFile($file, $directory, $disk);
        }

        try {
            $realPath = is_object($file) && method_exists($file, 'getRealPath')
                ? $file->getRealPath()
                : (string) $file;

            // 1. Read / Decode image
            $image = Image::decode($realPath);

            // 2. Auto-orient according to EXIF data (fixes rotated smartphone photos)
            $image->orient();

            // 3. Proportional scale-down (only downscales if image exceeds $maxWidth)
            $image->scaleDown(width: $maxWidth, height: $maxWidth);

            // 4. Encode to target format with specified compression quality
            $encoded = $image->encodeUsingFileExtension($format, quality: $quality);

            // 5. Generate unique name and store in designated disk
            $filename = Str::uuid()->toString() . '.' . strtolower($format);
            $cleanDirectory = trim($directory, '/');
            $storagePath = $cleanDirectory ? "{$cleanDirectory}/{$filename}" : $filename;

            Storage::disk($disk)->put($storagePath, (string) $encoded);

            return $storagePath;
        } catch (\Throwable $e) {
            Log::warning("ImageService compression fallback: " . $e->getMessage());

            // Safe fallback: standard upload without compression if decode fails
            if (is_object($file) && method_exists($file, 'store')) {
                return $file->store($directory, $disk);
            }

            throw $e;
        }
    }

    /**
     * Delete an existing image file from storage if present.
     */
    public static function delete(?string $path, string $disk = 'public'): bool
    {
        if (empty($path)) {
            return false;
        }

        if (Storage::disk($disk)->exists($path)) {
            return Storage::disk($disk)->delete($path);
        }

        return false;
    }

    /**
     * Detect MIME type of the given file.
     */
    private static function detectMimeType(mixed $file): ?string
    {
        if (is_object($file) && method_exists($file, 'getMimeType')) {
            return $file->getMimeType();
        }

        if (is_string($file) && file_exists($file)) {
            return mime_content_type($file) ?: null;
        }

        return null;
    }

    /**
     * Fallback for raw file path storing.
     */
    private static function storeRawFile(string $sourcePath, string $directory, string $disk): string
    {
        $extension = pathinfo($sourcePath, PATHINFO_EXTENSION) ?: 'bin';
        $filename = Str::uuid()->toString() . '.' . $extension;
        $cleanDirectory = trim($directory, '/');
        $targetPath = $cleanDirectory ? "{$cleanDirectory}/{$filename}" : $filename;

        Storage::disk($disk)->put($targetPath, file_get_contents($sourcePath));

        return $targetPath;
    }
}
