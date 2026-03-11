<?php

if (! function_exists('lroute')) {
    /**
     * Génère une route avec la locale courante
     * Usage : lroute('about')  →  /fr/a-propos
     */
    function lroute(string $name, array $params = []): string
    {
        return route($name, array_merge(
            ['locale' => app()->getLocale()],
            $params
        ));
    }
}

if (! function_exists('switch_locale_url')) {
    /**
     * Génère l'URL de la page courante dans une autre locale
     * Usage : switch_locale_url('en')  →  /en/formations/...
     */
    function switch_locale_url(string $locale): string
    {
        $current = request()->route()->getName();
        $params  = request()->route()->parameters();
        $params['locale'] = $locale;
        return route($current, $params);
    }
}

if (! function_exists('image_url')) {
    /**
     * Retourne l'URL correcte d'une image
     * - URL Cloudinary (http/https) → retournée telle quelle
     * - Chemin local storage        → Storage::url($path)
     *
     * Usage : image_url($model->image)
     */
    function image_url(?string $path): string
    {
        if (!$path) return '';

        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
            return $path;
        }

        return \Illuminate\Support\Facades\Storage::url($path);
    }
}