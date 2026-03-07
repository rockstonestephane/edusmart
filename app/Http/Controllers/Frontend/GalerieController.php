<?php
namespace App\Http\Controllers\Frontend;
use App\Http\Controllers\Controller;
use App\Models\Galerie;
use App\Models\PageHero;

class GalerieController extends Controller
{
    public function index($locale)
    {
        $photos = Galerie::orderBy('ordre')
            ->paginate(config('school.pagination.galerie', 12));

        $categories = Galerie::distinct()->pluck('categorie')->filter();

        $hero = PageHero::getForPage('galerie');

        return view('frontend.pages.galerie', compact('photos', 'categories', 'hero'));
    }
}