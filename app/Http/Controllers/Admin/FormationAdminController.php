<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\HandlesImageUpload;
use App\Models\Formation;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class FormationAdminController extends Controller
{
    use HandlesImageUpload;

    public function index()
    {
        $formations = Formation::orderBy('ordre')->paginate(config('school.pagination.admin', 15));
        return view('admin.formations.index', compact('formations'));
    }

    public function create()
    {
        return view('admin.formations.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'titre'   => 'required|string|max:200',
            'extrait' => 'required|string|max:500',
            'contenu' => 'nullable|string',
            'image'   => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
            'icon'    => 'nullable|string|max:10',
            'color'   => 'nullable|string|max:100',
            'tags'    => 'nullable|string',
            'ordre'   => 'integer|min:0',
            'active'  => 'boolean',
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $this->storeAsWebp(
                $request->file('image'),
                config('school.upload.paths.formations'),
                quality: 82,
                maxWidth: 1200
            );
        }

        $data['tags']   = $this->parseTags($request->input('tags'));
        $data['slug']   = Str::slug($data['titre']);
        $data['active'] = $request->boolean('active', true);
        $data['ordre']  = $request->input('ordre', Formation::max('ordre') + 1);

        Formation::create($data);

        return redirect()->route('admin.formations.index')
            ->with('success', 'Formation créée avec succès !');
    }

    public function edit(Formation $formation)
    {
        return view('admin.formations.edit', compact('formation'));
    }

    public function update(Request $request, Formation $formation)
    {
        $data = $request->validate([
            'titre'   => 'required|string|max:200',
            'extrait' => 'required|string|max:500',
            'contenu' => 'nullable|string',
            'image'   => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
            'icon'    => 'nullable|string|max:10',
            'color'   => 'nullable|string|max:100',
            'tags'    => 'nullable|string',
            'ordre'   => 'integer|min:0',
            'active'  => 'boolean',
        ]);

        if ($request->hasFile('image')) {
            $this->deleteImage($formation->image);
            $data['image'] = $this->storeAsWebp(
                $request->file('image'),
                config('school.upload.paths.formations'),
                quality: 82,
                maxWidth: 1200
            );
        }

        $data['tags']   = $this->parseTags($request->input('tags'));
        $data['slug']   = Str::slug($data['titre']);
        $data['active'] = $request->boolean('active');

        $formation->update($data);

        return redirect()->route('admin.formations.index')
            ->with('success', 'Formation mise à jour avec succès !');
    }

    public function destroy(Formation $formation)
    {
        $this->deleteImage($formation->image);
        $formation->delete();

        return redirect()->route('admin.formations.index')
            ->with('success', 'Formation supprimée !');
    }

    public function toggle(Formation $formation)
    {
        $formation->update(['active' => !$formation->active]);
        return back()->with('success', 'Statut mis à jour !');
    }

    private function parseTags(?string $tags): array
    {
        if (empty($tags)) return [];
        return array_values(array_filter(
            array_map('trim', explode(',', $tags))
        ));
    }
}