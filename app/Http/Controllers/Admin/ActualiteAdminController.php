<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\HandlesImageUpload;
use App\Models\Actualite;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ActualiteAdminController extends Controller
{
    use HandlesImageUpload;

    public function index()
    {
        $actualites = Actualite::latest()->paginate(config('school.pagination.admin', 15));
        return view('admin.actualites.index', compact('actualites'));
    }

    public function create()
    {
        return view('admin.actualites.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'titre'      => 'required|string|max:200',
            'extrait'    => 'required|string|max:500',
            'contenu'    => 'required|string',
            'image'      => 'required|image|mimes:jpg,jpeg,png,webp|max:4096',
            'categorie'  => 'required|string|max:60',
            'publiee'    => 'boolean',
        ]);

        $data['image'] = $this->storeAsWebp(
            $request->file('image'),
            config('school.upload.paths.actualites'),
            quality: 82,
            maxWidth: 1200
        );
        $data['slug']       = Str::slug($data['titre']);
        $data['publiee']    = $request->boolean('publiee', true);
        $data['published_at'] = now();

        Actualite::create($data);

        return redirect()->route('admin.actualites.index')
            ->with('success', 'Actualité créée avec succès !');
    }

    public function edit(Actualite $actualite)
    {
        return view('admin.actualites.edit', compact('actualite'));
    }

    public function update(Request $request, Actualite $actualite)
    {
        $data = $request->validate([
            'titre'     => 'required|string|max:200',
            'extrait'   => 'required|string|max:500',
            'contenu'   => 'required|string',
            'image'     => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
            'categorie' => 'required|string|max:60',
            'publiee'   => 'boolean',
        ]);

        if ($request->hasFile('image')) {
            $this->deleteImage($actualite->image);
            $data['image'] = $this->storeAsWebp(
                $request->file('image'),
                config('school.upload.paths.actualites'),
                quality: 82,
                maxWidth: 1200
            );
        }

        $data['slug']    = Str::slug($data['titre']);
        $data['publiee'] = $request->boolean('publiee');

        $actualite->update($data);

        return redirect()->route('admin.actualites.index')
            ->with('success', 'Actualité mise à jour avec succès !');
    }

    public function destroy(Actualite $actualite)
    {
        $this->deleteImage($actualite->image);
        $actualite->delete();

        return redirect()->route('admin.actualites.index')
            ->with('success', 'Actualité supprimée !');
    }

    public function toggle(Actualite $actualite)
    {
        $actualite->update(['publiee' => !$actualite->publiee]);
        return back()->with('success', 'Statut mis à jour !');
    }
}