<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Statistique;
use Illuminate\Http\Request;

class StatistiqueController extends Controller
{
    public function index()
    {
        $statistiques = Statistique::orderBy('ordre')->get();
        return view('admin.statistiques.index', compact('statistiques'));
    }

    public function create()
    {
        return view('admin.statistiques.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'icone'   => 'nullable|string|max:10',
            'valeur'  => 'required|string|max:20',
            'suffixe' => 'nullable|string|max:10',
            'label'   => 'required|string|max:100',
            'ordre'   => 'integer|min:0',
            'actif'   => 'boolean',
        ]);

        $data['actif'] = $request->boolean('actif', true);
        $data['ordre'] = $request->input('ordre', Statistique::max('ordre') + 1);

        Statistique::create($data);

        return redirect()->route('admin.statistiques.index')
            ->with('success', 'Statistique créée avec succès !');
    }

    public function edit(Statistique $statistique)
    {
        return view('admin.statistiques.edit', compact('statistique'));
    }

    public function update(Request $request, Statistique $statistique)
    {
        $data = $request->validate([
            'icone'   => 'nullable|string|max:10',
            'valeur'  => 'required|string|max:20',
            'suffixe' => 'nullable|string|max:10',
            'label'   => 'required|string|max:100',
            'ordre'   => 'integer|min:0',
            'actif'   => 'boolean',
        ]);

        $data['actif'] = $request->boolean('actif');
        $statistique->update($data);

        return redirect()->route('admin.statistiques.index')
            ->with('success', 'Statistique mise à jour avec succès !');
    }

    public function destroy(Statistique $statistique)
    {
        $statistique->delete();
        return redirect()->route('admin.statistiques.index')
            ->with('success', 'Statistique supprimée avec succès !');
    }

    public function toggle(Statistique $statistique)
    {
        $statistique->update(['actif' => !$statistique->actif]);
        return back()->with('success', 'Statut mis à jour !');
    }
}