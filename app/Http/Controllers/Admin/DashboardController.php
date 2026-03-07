<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Actualite;
use App\Models\Formation;
use App\Models\Galerie;
use App\Models\HeroSlide;
use App\Models\Preinscription;
use App\Models\Temoignage;

class DashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard', [
            'stats' => [
                'hero_slides'     => HeroSlide::count(),
                'actualites'      => Actualite::count(),
                'formations'      => Formation::count(),
                'galerie'         => Galerie::count(),
                'temoignages'     => Temoignage::count(),
                'preinscriptions' => Preinscription::count(),
                'preinscriptions_attente'  => Preinscription::where('statut', 'en_attente')->count(),
                'preinscriptions_validees' => Preinscription::where('statut', 'validee')->count(),
            ],
            'dernières_preinscriptions' => Preinscription::latest()->take(5)->get(),
            'dernières_actualites'      => Actualite::latest()->take(4)->get(),
        ]);
    }
}