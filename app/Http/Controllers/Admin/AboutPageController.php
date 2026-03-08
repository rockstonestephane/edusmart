<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\HandlesImageUpload;
use App\Models\AboutPage;
use Illuminate\Http\Request;

class AboutPageController extends Controller
{
    use HandlesImageUpload;

    public function index()
    {
        $about = AboutPage::getInstance();
        return view('admin.about.index', compact('about'));
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'hero_image'  => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
            'histoire_p1' => 'nullable|string|max:1000',
            'histoire_p2' => 'nullable|string|max:1000',
            'histoire_p3' => 'nullable|string|max:1000',
        ]);

        $about = AboutPage::getInstance();

        if ($request->hasFile('hero_image')) {
            $this->deleteImage($about->hero_image);
            $data['hero_image'] = $this->storeAsWebp(
                $request->file('hero_image'),
                'about',
                quality: 82,
                maxWidth: 1920
            );
        }

        $about->update($data);

        return redirect()->route('admin.about.index')
            ->with('success', 'Page À propos mise à jour avec succès !');
    }
}