<?php
namespace App\Http\Controllers\Traits;

use Illuminate\Http\UploadedFile;
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

        // Configurer Cloudinary
        Configuration::instance(config('cloudinary.cloud_url'));
        $cloudinary = new Cloudinary();

        // Sauvegarde temporaire du fichier
        $tempPath = sys_get_temp_dir() . '/' . Str::random(40) . '.webp';
        file_put_contents($tempPath, $webpData);

        // Upload vers Cloudinary
        $result = $cloudinary->uploadApi()->upload($tempPath, [
            'folder' => 'edusmart/' . $folder,
            'resource_type' => 'image',
            'format' => 'webp',
        ]);

        // Nettoyage du fichier temporaire
        unlink($tempPath);

        // Retourne l'URL sécurisée Cloudinary
        return $result['secure_url'];
    }

    protected function deleteImage(?string $path): void
    {
        if ($path && str_contains($path, 'cloudinary.com')) {
            // Extraire le public_id de l'image
            preg_match('/edusmart\/.*(?=\.webp)/', $path, $matches);
            if (!empty($matches[0])) {
                Configuration::instance(config('cloudinary.cloud_url'));
                $cloudinary = new Cloudinary();
                $cloudinary->uploadApi()->destroy($matches[0], [
                    'resource_type' => 'image'
                ]);
            }
        }
    }
}
