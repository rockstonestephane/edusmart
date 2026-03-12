<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\HandlesImageUpload;
use App\Models\Equipe;
use Illuminate\Http\Request;

class EquipeController extends Controller
{
    use HandlesImageUpload;

    public function index()
    {
        $membres = Equipe::orderBy('ordre')->paginate(config('school.pagination.admin', 15));
        return view('admin.equipe.index', compact('membres'));
    }

    public function create()
    {
        return view('admin.equipe.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nom'        => 'required|string|max:200',
            'poste'      => 'required|string|max:200',
            'bio'        => 'nullable|string',
            'photo'      => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
            'ordre'      => 'nullable|integer|min:0',
            'actif'      => 'boolean',
        ]);

        if ($request->hasFile('photo')) {
            $data['photo'] = $this->storeAsWebp(
                $request->file('photo'),
                'equipe',
                quality: 85,
                maxWidth: 600
            );
        }

        $data['actif'] = $request->boolean('actif', true);
        $data['ordre'] = $data['ordre'] ?? Equipe::max('ordre') + 1;

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
            'nom'   => 'required|string|max:200',
            'poste' => 'required|string|max:200',
            'bio'   => 'nullable|string',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
            'ordre' => 'nullable|integer|min:0',
            'actif' => 'boolean',
        ]);

        if ($request->hasFile('photo')) {
            $this->deleteImage($equipe->photo);
            $data['photo'] = $this->storeAsWebp(
                $request->file('photo'),
                'equipe',
                quality: 85,
                maxWidth: 600
            );
        }

        $data['actif'] = $request->boolean('actif');

        $equipe->update($data);

        return redirect()->route('admin.equipe.index')
            ->with('success', 'Membre mis à jour avec succès !');
    }

    public function destroy(Equipe $equipe)
    {
        $this->deleteImage($equipe->photo);
        $equipe->delete();

        return redirect()->route('admin.equipe.index')
            ->with('success', 'Membre supprimé !');
    }

    public function toggle(Equipe $equipe)
    {
        $equipe->update(['actif' => !$equipe->actif]);
        return back()->with('success', 'Statut mis à jour !');
    }
}