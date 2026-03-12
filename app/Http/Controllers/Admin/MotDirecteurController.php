<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\HandlesImageUpload;
use App\Models\MotDirecteur;
use Illuminate\Http\Request;

class MotDirecteurController extends Controller
{
    use HandlesImageUpload;

    public function edit()
    {
        $motDirecteur = MotDirecteur::first() ?? new MotDirecteur();
        return view('admin.mot_directeur.edit', compact('motDirecteur'));
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'nom'       => 'required|string|max:200',
            'poste'     => 'required|string|max:200',
            'texte'     => 'required|string',
            'photo'     => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
            'signature' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $motDirecteur = MotDirecteur::first() ?? new MotDirecteur();

        if ($request->hasFile('photo')) {
            $this->deleteImage($motDirecteur->photo);
            $data['photo'] = $this->storeAsWebp(
                $request->file('photo'),
                'mot-directeur',
                quality: 85,
                maxWidth: 800
            );
        }

        if ($request->hasFile('signature')) {
            $this->deleteImage($motDirecteur->signature);
            $data['signature'] = $this->storeAsWebp(
                $request->file('signature'),
                'mot-directeur',
                quality: 90,
                maxWidth: 400
            );
        }

        $motDirecteur->fill($data)->save();

        return redirect()->route('admin.mot_directeur.edit')
            ->with('success', 'Mot du Directeur mis à jour avec succès !');
    }
}