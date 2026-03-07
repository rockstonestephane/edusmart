<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Temoignage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TemoignageAdminController extends Controller
{
    public function index()
    {
        $temoignages = Temoignage::orderBy('ordre')->paginate(config('school.pagination.admin', 15));
        return view('admin.temoignages.index', compact('temoignages'));
    }

    public function create()
    {
        return view('admin.temoignages.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nom'   => 'required|string|max:100',
            'role'  => 'required|string|max:100',
            'texte' => 'required|string|max:1000',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'note'  => 'required|integer|min:1|max:5',
            'ordre' => 'integer|min:0',
            'publie'=> 'boolean',
        ]);

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')
                ->store(config('school.upload.paths.temoignages'), 'public');
        }

        $data['publie'] = $request->boolean('publie', true);
        $data['ordre']  = $request->input('ordre', Temoignage::max('ordre') + 1);

        Temoignage::create($data);

        return redirect()->route('admin.temoignages.index')
            ->with('success', 'Témoignage ajouté avec succès !');
    }

    public function edit(Temoignage $temoignage)
    {
        return view('admin.temoignages.edit', compact('temoignage'));
    }

    public function update(Request $request, Temoignage $temoignage)
    {
        $data = $request->validate([
            'nom'   => 'required|string|max:100',
            'role'  => 'required|string|max:100',
            'texte' => 'required|string|max:1000',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'note'  => 'required|integer|min:1|max:5',
            'ordre' => 'integer|min:0',
            'publie'=> 'boolean',
        ]);

        if ($request->hasFile('photo')) {
            if ($temoignage->photo) {
                Storage::disk('public')->delete($temoignage->photo);
            }
            $data['photo'] = $request->file('photo')
                ->store(config('school.upload.paths.temoignages'), 'public');
        }

        $data['publie'] = $request->boolean('publie');
        $temoignage->update($data);

        return redirect()->route('admin.temoignages.index')
            ->with('success', 'Témoignage mis à jour !');
    }

    public function destroy(Temoignage $temoignage)
    {
        if ($temoignage->photo) {
            Storage::disk('public')->delete($temoignage->photo);
        }
        $temoignage->delete();

        return redirect()->route('admin.temoignages.index')
            ->with('success', 'Témoignage supprimé !');
    }

    public function toggle(Temoignage $temoignage)
    {
        $temoignage->update(['publie' => !$temoignage->publie]);
        return back()->with('success', 'Statut mis à jour !');
    }
}