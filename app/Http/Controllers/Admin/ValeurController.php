<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Valeur;
use Illuminate\Http\Request;

class ValeurController extends Controller
{
    public function index()
    {
        $valeurs = Valeur::orderBy('ordre')->get();
        return view('admin.valeurs.index', compact('valeurs'));
    }

    public function create()
    {
        return view('admin.valeurs.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'icone'       => 'nullable|string|max:10',
            'titre'       => 'required|string|max:100',
            'description' => 'required|string|max:500',
            'couleur'     => 'nullable|string|max:100',
            'ordre'       => 'integer|min:0',
            'actif'       => 'boolean',
        ]);

        $data['actif'] = $request->boolean('actif', true);
        $data['ordre'] = $request->input('ordre', Valeur::max('ordre') + 1);

        Valeur::create($data);

        return redirect()->route('admin.valeurs.index')
            ->with('success', 'Valeur créée avec succès !');
    }

    public function edit(Valeur $valeur)
    {
        return view('admin.valeurs.edit', compact('valeur'));
    }

    public function update(Request $request, Valeur $valeur)
    {
        $data = $request->validate([
            'icone'       => 'nullable|string|max:10',
            'titre'       => 'required|string|max:100',
            'description' => 'required|string|max:500',
            'couleur'     => 'nullable|string|max:100',
            'ordre'       => 'integer|min:0',
            'actif'       => 'boolean',
        ]);

        $data['actif'] = $request->boolean('actif');
        $valeur->update($data);

        return redirect()->route('admin.valeurs.index')
            ->with('success', 'Valeur mise à jour avec succès !');
    }

    public function destroy(Valeur $valeur)
    {
        $valeur->delete();
        return redirect()->route('admin.valeurs.index')
            ->with('success', 'Valeur supprimée avec succès !');
    }

    public function toggle(Valeur $valeur)
    {
        $valeur->update(['actif' => !$valeur->actif]);
        return back()->with('success', 'Statut mis à jour !');
    }
}