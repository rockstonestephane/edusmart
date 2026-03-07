<?php
namespace App\Http\Controllers\Frontend;
use App\Http\Controllers\Controller;
use App\Models\Formation;
use App\Models\PageHero;

class FormationController extends Controller
{
    public function index($locale)
    {
        $formations = Formation::where('active', true)
            ->orderBy('ordre')
            ->paginate(config('school.pagination.formations', 12));

        $hero = PageHero::getForPage('formations');

        return view('frontend.pages.formations', compact('formations', 'hero'));
    }

    public function show($locale, $slug)
    {
        $formation = Formation::where('slug', $slug)
            ->where('active', true)
            ->firstOrFail();

        $autres = Formation::where('active', true)
            ->where('id', '!=', $formation->id)
            ->orderBy('ordre')
            ->take(3)
            ->get();

        return view('frontend.pages.formations-show', compact('formation', 'autres'));
    }
}