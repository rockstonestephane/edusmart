<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Preinscription;
use Illuminate\Http\Request;

class PreinscriptionAdminController extends Controller
{
    public function index(Request $request)
    {
        $query = Preinscription::latest();

        // Filtre par statut
        if ($request->filled('statut')) {
            $query->where('statut', $request->statut);
        }

        // Recherche par nom
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('nom',    'like', '%'.$request->search.'%')
                  ->orWhere('prenom','like', '%'.$request->search.'%')
                  ->orWhere('email_parent','like', '%'.$request->search.'%');
            });
        }

        $preinscriptions = $query->paginate(config('school.pagination.admin', 15))
                                 ->withQueryString();

        $counts = [
            'total'      => Preinscription::count(),
            'en_attente' => Preinscription::where('statut', 'en_attente')->count(),
            'validee'    => Preinscription::where('statut', 'validee')->count(),
            'refusee'    => Preinscription::where('statut', 'refusee')->count(),
            'en_cours'   => Preinscription::where('statut', 'en_cours')->count(),
        ];

        return view('admin.preinscriptions.index', compact('preinscriptions', 'counts'));
    }

    public function show(Preinscription $preinscription)
    {
        return view('admin.preinscriptions.show', compact('preinscription'));
    }

    public function destroy(Preinscription $preinscription)
    {
        $preinscription->delete();
        return redirect()->route('admin.preinscriptions.index')
            ->with('success', 'Préinscription supprimée !');
    }

    public function statut(Request $request, Preinscription $preinscription)
    {
        $request->validate([
            'statut' => 'required|in:en_attente,validee,refusee,en_cours',
        ]);

        $preinscription->update(['statut' => $request->statut]);

        return back()->with('success', 'Statut mis à jour avec succès !');
    }
}