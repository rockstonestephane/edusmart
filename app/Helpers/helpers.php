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