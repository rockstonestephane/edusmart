<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Http\View\Composers\SchoolComposer;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void {}

    public function boot(): void
    {
        Schema::defaultStringLength(191);
        // Partage les variables school sur toutes les vues frontend
        View::composer([
            'frontend.components.navbar',
            'frontend.components.footer',
            'frontend.layouts.frontend',
        ], SchoolComposer::class);
    }
}