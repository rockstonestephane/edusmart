<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RentreeScolaire;
use Illuminate\Http\Request;

class RentreeScolaireController extends Controller
{
    public function index()
    {
        $rentrees = RentreeScolaire::orderByDesc('created_at')->get();
        return view('admin.rentree-scolaire.index', compact('rentrees'));
    }

    public function create()
    {
        return view('admin.rentree-scolaire.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'annee'       => 'required|string|max:20',
            'badge_label' => 'nullable|string|max:60',
            'titre'       => 'required|string|max:200',
            'description' => 'nullable|string|max:500',
            'btn1_label'  => 'nullable|string|max:60',
            'btn1_url'    => 'nullable|string|max:200',
            'btn2_label'  => 'nullable|string|max:60',
            'btn2_url'    => 'nullable|string|max:200',
            'actif'       => 'boolean',
        ]);

        // Si on active celle-ci, on désactive les autres
        if ($request->boolean('actif', true)) {
            RentreeScolaire::query()->update(['actif' => false]);
        }

        $data['actif'] = $request->boolean('actif', true);

        RentreeScolaire::create($data);

        return redirect()->route('admin.rentree-scolaire.index')
            ->with('success', 'Rentrée scolaire créée avec succès !');
    }

    public function edit(RentreeScolaire $rentreeScolaire)
    {
        return view('admin.rentree-scolaire.edit', compact('rentreeScolaire'));
    }

    public function update(Request $request, RentreeScolaire $rentreeScolaire)
    {
        $data = $request->validate([
            'annee'       => 'required|string|max:20',
            'badge_label' => 'nullable|string|max:60',
            'titre'       => 'required|string|max:200',
            'description' => 'nullable|string|max:500',
            'btn1_label'  => 'nullable|string|max:60',
            'btn1_url'    => 'nullable|string|max:200',
            'btn2_label'  => 'nullable|string|max:60',
            'btn2_url'    => 'nullable|string|max:200',
            'actif'       => 'boolean',
        ]);

        // Si on active celle-ci, on désactive les autres
        if ($request->boolean('actif')) {
            RentreeScolaire::where('id', '!=', $rentreeScolaire->id)
                ->update(['actif' => false]);
        }

        $data['actif'] = $request->boolean('actif');
        $rentreeScolaire->update($data);

        return redirect()->route('admin.rentree-scolaire.index')
            ->with('success', 'Rentrée scolaire mise à jour avec succès !');
    }

    public function destroy(RentreeScolaire $rentreeScolaire)
    {
        $rentreeScolaire->delete();
        return redirect()->route('admin.rentree-scolaire.index')
            ->with('success', 'Rentrée scolaire supprimée avec succès !');
    }

    public function toggle(RentreeScolaire $rentreeScolaire)
    {
        // Une seule rentrée active à la fois
        if (!$rentreeScolaire->actif) {
            RentreeScolaire::query()->update(['actif' => false]);
        }
        $rentreeScolaire->update(['actif' => !$rentreeScolaire->actif]);
        return back()->with('success', 'Statut mis à jour !');
    }
}