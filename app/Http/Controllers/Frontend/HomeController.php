<?php
namespace App\Http\Controllers\Frontend;
use App\Http\Controllers\Controller;
use App\Models\Actualite;
use App\Models\Formation;
use App\Models\Galerie;
use App\Models\HeroSlide;
use App\Models\Temoignage;
use App\Models\Statistique;
use App\Models\RentreeScolaire;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index($locale)
    {
        return view('frontend.pages.home', [
            'heroSlides' => HeroSlide::where('actif', true)
                ->orderBy('ordre')->get(),
            'actualites' => Actualite::where('publiee', true)
                ->latest('published_at')->take(6)->get(),
            'formations' => Formation::where('active', true)
                ->orderBy('ordre')->take(6)->get(),
            'galerie'    => Galerie::where('homepage', true)
                ->orderBy('ordre')->take(6)->get(),
            'temoignages' => Temoignage::where('publie', true)
                ->orderBy('ordre')->take(6)->get(),
            'statistiques' => Statistique::where('actif', true)
                ->orderBy('ordre')->get(),
            'rentree' => RentreeScolaire::where('actif', true)->first(),
        ]);
    }

    public function newsletter(Request $request, $locale)
    {
        $request->validate(['email' => 'required|email']);
        return back()->with('success', 'Merci ! Vous êtes bien inscrit à notre newsletter.');
    }
}