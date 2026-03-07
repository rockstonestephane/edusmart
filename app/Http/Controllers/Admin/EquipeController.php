<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Equipe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EquipeController extends Controller
{
    public function index()
    {
        $membres = Equipe::orderBy('ordre')->get();
        return view('admin.equipe.index', compact('membres'));
    }

    public function create()
    {
        return view('admin.equipe.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'photo'  => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'nom'    => 'required|string|max:100',
            'poste'  => 'required|string|max:100',
            'bio'    => 'nullable|string|max:500',
            'ordre'  => 'integer|min:0',
            'actif'  => 'boolean',
        ]);

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')
                ->store('equipe', 'public');
        }

        $data['actif'] = $request->boolean('actif', true);
        $data['ordre'] = $request->input('ordre', Equipe::max('ordre') + 1);

        Equipe::create($data);

        return redirect()->route('admin.equipe.index')
            ->with('success', 'Membre ajouté avec succès !');
    }

    public function edit(Equipe $equipe)
    {
        return view('admin.equipe.edit', compact('equipe'));
    }

    public function update(Request $request, Equipe $equipe)
    {
        $data = $request->validate([
            'photo'  => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'nom'    => 'required|string|max:100',
            'poste'  => 'required|string|max:100',
            'bio'    => 'nullable|string|max:500',
            'ordre'  => 'integer|min:0',
            'actif'  => 'boolean',
        ]);

        if ($request->hasFile('photo')) {
            if ($equipe->photo) {
                Storage::disk('public')->delete($equipe->photo);
            }
            $data['photo'] = $request->file('photo')
                ->store('equipe', 'public');
        }

        $data['actif'] = $request->boolean('actif');
        $equipe->update($data);

        return redirect()->route('admin.equipe.index')
            ->with('success', 'Membre mis à jour avec succès !');
    }

    public function destroy(Equipe $equipe)
    {
        if ($equipe->photo) {
            Storage::disk('public')->delete($equipe->photo);
        }
        $equipe->delete();

        return redirect()->route('admin.equipe.index')
            ->with('success', 'Membre supprimé avec succès !');
    }

    public function toggle(Equipe $equipe)
    {
        $equipe->update(['actif' => !$equipe->actif]);
        return back()->with('success', 'Statut mis à jour !');
    }
}