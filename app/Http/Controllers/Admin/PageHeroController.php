<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PageHero;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PageHeroController extends Controller
{
    /**
     * Pages disponibles avec leurs labels
     */
    private array $pages = [
        'formations' => '📚 Formations',
        'actualites' => '📰 Actualités',
        'galerie'    => '🎨 Galerie',
        'contact'    => '✉️ Contact',
    ];

    /**
     * Affiche le formulaire de gestion des images hero
     */
    public function index()
    {
        $heroes = [];
        foreach ($this->pages as $key => $label) {
            $heroes[$key] = [
                'label' => $label,
                'hero'  => PageHero::getForPage($key),
            ];
        }

        return view('admin.page-heroes.index', compact('heroes'));
    }

    /**
     * Met à jour l'image hero d'une page
     */
    public function update(Request $request, string $page)
    {
        if (!array_key_exists($page, $this->pages)) {
            abort(404);
        }

        $request->validate([
            'image' => 'required|image|mimes:jpg,jpeg,png,webp|max:4096',
        ]);

        $hero = PageHero::getForPage($page);

        // Supprime l'ancienne image
        if ($hero->image) {
            Storage::disk('public')->delete($hero->image);
        }

        // Enregistre la nouvelle
        $hero->update([
            'image' => $request->file('image')->store('heroes', 'public'),
        ]);

        return back()->with('success', "Image hero de la page {$this->pages[$page]} mise à jour !");
    }

    /**
     * Supprime l'image hero d'une page
     */
    public function destroy(string $page)
    {
        if (!array_key_exists($page, $this->pages)) {
            abort(404);
        }

        $hero = PageHero::getForPage($page);

        if ($hero->image) {
            Storage::disk('public')->delete($hero->image);
            $hero->update(['image' => null]);
        }

        return back()->with('success', "Image hero supprimée !");
    }
}