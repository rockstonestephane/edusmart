<?php

namespace App\Http\Controllers\Traits;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Laravel\Facades\Image;

trait HandlesImageUpload
{
    /**
     * Convertit et stocke une image en WebP optimisée.
     *
     * @param  UploadedFile  $file      Fichier uploadé
     * @param  string        $folder    Dossier de destination (ex: 'actualites')
     * @param  int           $quality   Qualité WebP (1-100), défaut 82
     * @param  int|null      $maxWidth  Largeur max en px (null = pas de redimensionnement)
     * @return string        Chemin relatif stocké en base (ex: 'actualites/abc123.webp')
     */
    protected function storeAsWebp(
        UploadedFile $file,
        string $folder,
        int $quality = 82,
        ?int $maxWidth = null
    ): string {
        $filename = Str::random(40) . '.webp';
        $path     = $folder . '/' . $filename;

        $image = Image::read($file);

        // Redimensionne si nécessaire (conserve les proportions)
        if ($maxWidth && $image->width() > $maxWidth) {
            $image->scaleDown(width: $maxWidth);
        }

        // Encode en WebP et sauvegarde dans le disque public
        Storage::disk('public')->put(
            $path,
            $image->toWebp($quality)->toString()
        );

        return $path;
    }

    /**
     * Supprime une image existante du storage.
     *
     * @param string|null $path Chemin relatif de l'image
     */
    protected function deleteImage(?string $path): void
    {
        if ($path) {
            Storage::disk('public')->delete($path);
        }
    }
}