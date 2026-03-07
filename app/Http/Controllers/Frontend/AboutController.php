<?php
namespace App\Http\Controllers\Frontend;
use App\Http\Controllers\Controller;
use App\Models\AboutPage;
use App\Models\Valeur;
use App\Models\Equipe;
use App\Models\Statistique;
use App\Models\MotDirecteur;

class AboutController extends Controller
{
    public function index($locale)
    {
        return view('frontend.pages.about', [
            'about'         => AboutPage::getInstance(),
            'valeurs'       => Valeur::where('actif', true)->orderBy('ordre')->get(),
            'equipe'        => Equipe::where('actif', true)->orderBy('ordre')->get(),
            'statistiques'  => Statistique::where('actif', true)->orderBy('ordre')->get(),
            'motDirecteur'  => MotDirecteur::first(),
        ]);
    }
}