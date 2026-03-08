<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\HandlesImageUpload;
use App\Models\HeroSlide;
use Illuminate\Http\Request;

class HeroSlideController extends Controller
{
    use HandlesImageUpload;

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

        $data['image'] = $this->storeAsWebp(
            $request->file('image'),
            config('school.upload.paths.hero'),
            quality: 85,
            maxWidth: 1920
        );

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

        if ($request->hasFile('image')) {
            $this->deleteImage($heroSlide->image);
            $data['image'] = $this->storeAsWebp(
                $request->file('image'),
                config('school.upload.paths.hero'),
                quality: 85,
                maxWidth: 1920
            );
        }

        $data['actif'] = $request->boolean('actif');
        $heroSlide->update($data);

        return redirect()->route('admin.hero-slides.index')
            ->with('success', 'Slide mis à jour avec succès !');
    }

    public function destroy(HeroSlide $heroSlide)
    {
        $this->deleteImage($heroSlide->image);
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