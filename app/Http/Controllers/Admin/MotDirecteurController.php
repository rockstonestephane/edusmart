<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MotDirecteur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MotDirecteurController extends Controller
{
    /**
     * Afficher le formulaire d'édition
     * (une seule entrée en base, on prend la première)
     */
    public function edit()
    {
        $motDirecteur = MotDirecteur::first() ?? new MotDirecteur();
        return view('admin.mot_directeur.edit', compact('motDirecteur'));
    }

    /**
     * Enregistrer ou mettre à jour
     */
    public function update(Request $request)
    {
        $request->validate([
            'nom'       => 'required|string|max:255',
            'poste'     => 'required|string|max:255',
            'texte'     => 'required|string',
            'photo'     => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'signature' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:1024',
        ]);

        // On récupère l'entrée existante ou on en crée une nouvelle
        $motDirecteur = MotDirecteur::first() ?? new MotDirecteur();

        $motDirecteur->nom   = $request->nom;
        $motDirecteur->poste = $request->poste;
        $motDirecteur->texte = $request->texte;

        // Gestion upload photo
        if ($request->hasFile('photo')) {
            // Supprimer l'ancienne photo si elle existe
            if ($motDirecteur->photo) {
                Storage::disk('public')->delete($motDirecteur->photo);
            }
            $motDirecteur->photo = $request->file('photo')
                                           ->store('directeur', 'public');
        }

        // Gestion upload signature
        if ($request->hasFile('signature')) {
            if ($motDirecteur->signature) {
                Storage::disk('public')->delete($motDirecteur->signature);
            }
            $motDirecteur->signature = $request->file('signature')
                                               ->store('directeur', 'public');
        }

        $motDirecteur->save();

        return redirect()->route('admin.mot-directeur.edit')
                         ->with('success', 'Mot du directeur mis à jour avec succès !');
    }
}