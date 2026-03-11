<?php
namespace App\Http\Controllers\Traits;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Laravel\Facades\Image;
use Cloudinary\Cloudinary;
use Cloudinary\Configuration\Configuration;

trait HandlesImageUpload
{
    protected function storeAsWebp(
        UploadedFile $file,
        string $folder,
        int $quality = 82,
        ?int $maxWidth = null
    ): string {
        // Prépare l'image en WebP en mémoire
        $image = Image::read($file);

        if ($maxWidth && $image->width() > $maxWidth) {
            $image->scaleDown(width: $maxWidth);
        }

        $webpData = $image->toWebp($quality)->toString();

        // Upload vers Cloudinary
        Configuration::instance(config('cloudinary.cloud_url'));
        $cloudinary = new Cloudinary();

        $tempPath = sys_get_temp_dir() . '/' . Str::random(40) . '.webp';
        file_put_contents($tempPath, $webpData);

        $result = $cloudinary->uploadApi()->upload($tempPath, [
            'folder' => 'edusmart/' . $folder,
        ]);

        unlink($tempPath);

        return $result['secure_url'];
    }

    protected function deleteImage(?string $path): void
    {
        if ($path && str_contains($path, 'cloudinary.com')) {
            preg_match('/edusmart\/.*(?=\.\w+$)/', $path, $matches);
            if (!empty($matches[0])) {
                Configuration::instance(config('cloudinary.cloud_url'));
                $cloudinary = new Cloudinary();
                $cloudinary->uploadApi()->destroy($matches[0]);
            }
        } elseif ($path) {
            Storage::disk('public')->delete($path);
        }
    }
}