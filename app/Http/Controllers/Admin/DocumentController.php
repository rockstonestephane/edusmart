<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
    public function index()
    {
        $documents = Document::orderBy('ordre')->orderBy('categorie')->get();
        return view('admin.documents.index', compact('documents'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nom'         => 'required|string|max:150',
            'description' => 'nullable|string|max:300',
            'categorie'   => 'required|string|in:tarifs,inscription,formulaires,general',
            'fichier'     => 'required|file|mimes:pdf,doc,docx,xlsx,xls|max:10240',
            'ordre'       => 'nullable|integer',
            'actif'       => 'nullable|boolean',
        ]);

        $file = $request->file('fichier');
        $extension = $file->getClientOriginalExtension();
        $taille = round($file->getSize() / 1024); // Ko
        $path = $file->store('documents', 'public');

        Document::create([
            'nom'          => $data['nom'],
            'description'  => $data['description'] ?? null,
            'categorie'    => $data['categorie'],
            'fichier'      => $path,
            'type_fichier' => strtolower($extension),
            'taille_fichier' => $taille,
            'ordre'        => $data['ordre'] ?? 0,
            'actif'        => $request->boolean('actif', true),
        ]);

        return redirect()->route('admin.documents.index')
            ->with('success', 'Document ajouté avec succès !');
    }

    public function update(Request $request, Document $document)
    {
        $data = $request->validate([
            'nom'         => 'required|string|max:150',
            'description' => 'nullable|string|max:300',
            'categorie'   => 'required|string|in:tarifs,inscription,formulaires,general',
            'fichier'     => 'nullable|file|mimes:pdf,doc,docx,xlsx,xls|max:10240',
            'ordre'       => 'nullable|integer',
            'actif'       => 'nullable|boolean',
        ]);

        if ($request->hasFile('fichier')) {
            Storage::disk('public')->delete($document->fichier);
            $file = $request->file('fichier');
            $extension = $file->getClientOriginalExtension();
            $data['fichier'] = $file->store('documents', 'public');
            $data['type_fichier'] = strtolower($extension);
            $data['taille_fichier'] = round($file->getSize() / 1024);
        }

        $data['actif'] = $request->boolean('actif', true);
        $document->update($data);

        return redirect()->route('admin.documents.index')
            ->with('success', 'Document mis à jour !');
    }

    public function destroy(Document $document)
    {
        Storage::disk('public')->delete($document->fichier);
        $document->delete();

        return redirect()->route('admin.documents.index')
            ->with('success', 'Document supprimé !');
    }
}