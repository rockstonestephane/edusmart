<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Galerie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GalerieAdminController extends Controller
{
    public function index()
    {
        $photos = Galerie::orderBy('ordre')->paginate(config('school.pagination.admin', 15));
        return view('admin.galerie.index', compact('photos'));
    }

    public function create()
    {
        return view('admin.galerie.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'images'      => 'required',
            'images.*'    => 'image|mimes:jpg,jpeg,png,webp|max:4096',
            'categorie'   => 'nullable|string|max:60',
            'homepage'    => 'boolean',
        ]);

        $ordre = Galerie::max('ordre') + 1;

        // Upload multiple
        foreach ($request->file('images') as $file) {
            Galerie::create([
                'image'     => $file->store(config('school.upload.paths.galerie'), 'public'),
                'legende'   => $request->input('legende'),
                'categorie' => $request->input('categorie'),
                'homepage'  => $request->boolean('homepage', false),
                'ordre'     => $ordre++,
            ]);
        }

        return redirect()->route('admin.galerie.index')
            ->with('success', 'Photo(s) ajoutée(s) avec succès !');
    }

    public function edit(Galerie $galerie)
    {
        return view('admin.galerie.edit', compact('galerie'));
    }

    public function update(Request $request, Galerie $galerie)
    {
        $data = $request->validate([
            'legende'   => 'nullable|string|max:200',
            'categorie' => 'nullable|string|max:60',
            'homepage'  => 'boolean',
            'ordre'     => 'integer|min:0',
            'image'     => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
        ]);

        if ($request->hasFile('image')) {
            Storage::disk('public')->delete($galerie->image);
            $data['image'] = $request->file('image')
                ->store(config('school.upload.paths.galerie'), 'public');
        }

        $data['homepage'] = $request->boolean('homepage');
        $galerie->update($data);

        return redirect()->route('admin.galerie.index')
            ->with('success', 'Photo mise à jour !');
    }

    public function destroy(Galerie $galerie)
    {
        Storage::disk('public')->delete($galerie->image);
        $galerie->delete();

        return redirect()->route('admin.galerie.index')
            ->with('success', 'Photo supprimée !');
    }

    public function toggle(Galerie $galerie)
    {
        $galerie->update(['homepage' => !$galerie->homepage]);
        return back()->with('success', 'Statut homepage mis à jour !');
    }
}