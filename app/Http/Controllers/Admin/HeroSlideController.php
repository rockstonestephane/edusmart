<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HeroSlide;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HeroSlideController extends Controller
{
    public function index()
    {
        $slides = HeroSlide::orderBy('ordre')->get();
        return view('admin.hero-slides.index', compact('slides'));
    }

    public function create()
    {
        return view('admin.hero-slides.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'surtitre'    => 'nullable|string|max:100',
            'titre'       => 'required|string|max:200',
            'description' => 'nullable|string|max:500',
            'image'       => 'required|image|mimes:jpg,jpeg,png,webp|max:4096',
            'btn1_label'  => 'nullable|string|max:60',
            'btn1_url'    => 'nullable|string|max:200',
            'btn2_label'  => 'nullable|string|max:60',
            'btn2_url'    => 'nullable|string|max:200',
            'ordre'       => 'integer|min:0',
            'actif'       => 'boolean',
        ]);

        // Upload image
        $data['image'] = $request->file('image')
            ->store(config('school.upload.paths.hero'), 'public');

        $data['actif'] = $request->boolean('actif', true);
        $data['ordre'] = $request->input('ordre', HeroSlide::max('ordre') + 1);

        HeroSlide::create($data);

        return redirect()->route('admin.hero-slides.index')
            ->with('success', 'Slide créé avec succès !');
    }

    public function edit(HeroSlide $heroSlide)
    {
        return view('admin.hero-slides.edit', compact('heroSlide'));
    }

    public function update(Request $request, HeroSlide $heroSlide)
    {
        $data = $request->validate([
            'surtitre'    => 'nullable|string|max:100',
            'titre'       => 'required|string|max:200',
            'description' => 'nullable|string|max:500',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
            'btn1_label'  => 'nullable|string|max:60',
            'btn1_url'    => 'nullable|string|max:200',
            'btn2_label'  => 'nullable|string|max:60',
            'btn2_url'    => 'nullable|string|max:200',
            'ordre'       => 'integer|min:0',
            'actif'       => 'boolean',
        ]);

        // Nouvelle image uploadée ?
        if ($request->hasFile('image')) {
            Storage::disk('public')->delete($heroSlide->image);
            $data['image'] = $request->file('image')
                ->store(config('school.upload.paths.hero'), 'public');
        }

        $data['actif'] = $request->boolean('actif');

        $heroSlide->update($data);

        return redirect()->route('admin.hero-slides.index')
            ->with('success', 'Slide mis à jour avec succès !');
    }

    public function destroy(HeroSlide $heroSlide)
    {
        Storage::disk('public')->delete($heroSlide->image);
        $heroSlide->delete();

        return redirect()->route('admin.hero-slides.index')
            ->with('success', 'Slide supprimé avec succès !');
    }

    public function toggle(HeroSlide $heroSlide)
    {
        $heroSlide->update(['actif' => !$heroSlide->actif]);
        return back()->with('success', 'Statut mis à jour !');
    }
}