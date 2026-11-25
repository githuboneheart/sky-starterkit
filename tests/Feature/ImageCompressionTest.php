<?php

namespace Tests\Feature;

use App\Services\ImageService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ImageCompressionTest extends TestCase
{
    use RefreshDatabase;

    public function test_image_service_compresses_and_converts_to_webp(): void
    {
        Storage::fake('public');

        // Create a fake image 1600x1200
        $file = UploadedFile::fake()->image('test_photo.jpg', 1600, 1200);

        $path = ImageService::compressAndStore(
            file: $file,
            directory: 'test_uploads',
            disk: 'public',
            maxWidth: 800,
            quality: 80,
            format: 'webp'
        );

        $this->assertNotNull($path);
        $this->assertStringEndsWith('.webp', $path);
        Storage::disk('public')->assertExists($path);

        // Verify global helper
        $helperPath = compress_and_store_image(
            file: $file,
            directory: 'avatars',
            maxWidth: 400
        );
        $this->assertNotNull($helperPath);
        $this->assertStringEndsWith('.webp', $helperPath);
        Storage::disk('public')->assertExists($helperPath);

        // Verify delete
        $deleted = ImageService::delete($path, 'public');
        $this->assertTrue($deleted);
        Storage::disk('public')->assertMissing($path);
    }
}
