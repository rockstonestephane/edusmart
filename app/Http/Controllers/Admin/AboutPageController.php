<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AboutPage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AboutPageController extends Controller
{
    /**
     * Affiche le formulaire d'édition de la page About.
     * Pas de liste ici — une seule configuration.
     */
    public function index()
    {
        $about = AboutPage::getInstance();
        return view('admin.about.index', compact('about'));
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'hero_image'  => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
            'histoire_p1' => 'nullable|string|max:1000',
            'histoire_p2' => 'nullable|string|max:1000',
            'histoire_p3' => 'nullable|string|max:1000',
        ]);

        $about = AboutPage::getInstance();

        if ($request->hasFile('hero_image')) {
            // Supprime l'ancienne image si elle existe
            if ($about->hero_image) {
                Storage::disk('public')->delete($about->hero_image);
            }
            $data['hero_image'] = $request->file('hero_image')
                ->store('about', 'public');
        }

        $about->update($data);

        return redirect()->route('admin.about.index')
            ->with('success', 'Page À propos mise à jour avec succès !');
    }
}