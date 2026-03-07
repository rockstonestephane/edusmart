<?php
namespace App\Http\Controllers\Frontend;
use App\Http\Controllers\Controller;
use App\Models\Actualite;
use App\Models\PageHero;

class ActualiteController extends Controller
{
    public function index($locale)
    {
        $actualites = Actualite::where('publiee', true)
            ->latest('published_at')
            ->paginate(config('school.pagination.actualites', 9));

        $categories = Actualite::where('publiee', true)
            ->distinct()
            ->pluck('categorie');

        $hero = PageHero::getForPage('actualites');

        return view('frontend.pages.actualites', compact('actualites', 'categories', 'hero'));
    }

    public function show($locale, $slug)
    {
        $actualite = Actualite::where('slug', $slug)
            ->where('publiee', true)
            ->firstOrFail();

        $recentes = Actualite::where('publiee', true)
            ->where('id', '!=', $actualite->id)
            ->latest('published_at')
            ->take(3)
            ->get();

        return view('frontend.pages.actualites-show', compact('actualite', 'recentes'));
    }
}