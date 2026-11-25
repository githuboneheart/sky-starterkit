<?php

use App\Models\ActivityLog;
use App\Models\AppSetting;
use Illuminate\Support\Facades\Session;

if (!function_exists('setting')) {
    /**
     * Get or set app setting.
     */
    function setting(?string $key = null, mixed $default = null): mixed
    {
        if (is_null($key)) {
            return AppSetting::getAllCached();
        }

        return AppSetting::get($key, $default);
    }
}

if (!function_exists('activity_log')) {
    /**
     * Record an activity log.
     */
    function activity_log(string $action, string $module, string $description, ?array $properties = null): ActivityLog
    {
        return ActivityLog::record($action, $module, $description, $properties);
    }
}

if (!function_exists('is_impersonating')) {
    /**
     * Check if currently impersonating another user.
     */
    function is_impersonating(): bool
    {
        return Session::has('impersonated_by_id');
    }
}

if (!function_exists('impersonator_id')) {
    /**
     * Get original user ID during impersonation.
     */
    function impersonator_id(): ?int
    {
        return Session::get('impersonated_by_id');
    }
}

if (!function_exists('compress_and_store_image')) {
    /**
     * Compress, resize, and store an uploaded image globally.
     */
    function compress_and_store_image(
        mixed $file,
        string $directory = 'uploads',
        string $disk = 'public',
        int $maxWidth = 1200,
        int $quality = 80,
        string $format = 'webp'
    ): string {
        return \App\Services\ImageService::compressAndStore(
            file: $file,
            directory: $directory,
            disk: $disk,
            maxWidth: $maxWidth,
            quality: $quality,
            format: $format
        );
    }
}
