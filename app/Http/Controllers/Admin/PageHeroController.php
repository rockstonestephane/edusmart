<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\HandlesImageUpload;
use App\Models\PageHero;
use Illuminate\Http\Request;

class PageHeroController extends Controller
{
    use HandlesImageUpload;

    public function index()
    {
        $pages = ['accueil', 'a-propos', 'formations', 'actualites', 'galerie', 'contact'];

        $heroes = [];
        foreach ($pages as $page) {
            $heroes[$page] = [
                'hero'  => PageHero::firstOrCreate(['page' => $page]),
                'label' => ucfirst(str_replace('-', ' ', $page)),
            ];
        }

        return view('admin.page-heroes.index', compact('heroes'));
    }

    public function update(Request $request, $page)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpg,jpeg,png,webp|max:4096',
        ]);

        $pageHero = PageHero::where('page', $page)->firstOrFail();
        $this->deleteImage($pageHero->image);
        $pageHero->image = $this->storeAsWebp(
            $request->file('image'),
            'page-heroes',
            quality: 85,
            maxWidth: 1920
        );
        $pageHero->save();

        return back()->with('success', 'Image mise à jour avec succès !');
    }

    public function destroy($page)
    {
        $pageHero = PageHero::where('page', $page)->firstOrFail();
        $this->deleteImage($pageHero->image);
        $pageHero->image = null;
        $pageHero->save();

        return back()->with('success', 'Image supprimée !');
    }
}