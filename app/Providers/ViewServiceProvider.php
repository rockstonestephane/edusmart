<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Statistique;
use App\Models\Document;

class ViewServiceProvider extends ServiceProvider
{
    public function boot(): void
{
    View::composer('frontend.components.footer', function ($view) {
        $view->with('statistiques', Statistique::orderBy('ordre')->get());
    });

    View::composer('frontend.pages.preinscription', function ($view) {
        $view->with('documents', Document::actif()->get());
    });
}
}