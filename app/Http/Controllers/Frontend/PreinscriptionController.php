<?php
namespace App\Http\Controllers\Frontend;
use App\Http\Controllers\Controller;
use App\Models\PageHero;
use App\Models\Preinscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
class PreinscriptionController extends Controller
{
    public function index()
    {
        $hero = PageHero::getForPage('preinscription');
        return view('frontend.pages.preinscription', compact('hero'));
    }
    public function store(Request $request)
    {
        $data = $request->validate([
            'nom'               => 'required|string|max:100',
            'prenom'            => 'required|string|max:100',
            'date_naissance'    => 'required|date',
            'sexe'              => 'required|in:masculin,feminin',
            'classe_demandee'   => 'required|string|max:60',
            'annee_scolaire'    => 'required|string|max:20',
            'nom_parent'        => 'required|string|max:100',
            'telephone_parent'  => 'required|string|max:30',
            'email_parent'      => 'required|email|max:100',
            'adresse'           => 'nullable|string|max:200',
            'message'           => 'nullable|string|max:1000',
            'acte_naissance'    => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'bulletin'          => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ], [
            'nom.required'              => 'Le nom de l\'élève est obligatoire.',
            'prenom.required'           => 'Le prénom de l\'élève est obligatoire.',
            'date_naissance.required'   => 'La date de naissance est obligatoire.',
            'sexe.required'             => 'Le sexe est obligatoire.',
            'classe_demandee.required'  => 'La classe demandée est obligatoire.',
            'annee_scolaire.required'   => 'L\'année scolaire est obligatoire.',
            'nom_parent.required'       => 'Le nom du parent est obligatoire.',
            'telephone_parent.required' => 'Le téléphone du parent est obligatoire.',
            'email_parent.required'     => 'L\'email du parent est obligatoire.',
            'email_parent.email'        => 'L\'adresse email n\'est pas valide.',
            'acte_naissance.mimes'      => 'L\'acte de naissance doit être un PDF, JPG ou PNG.',
            'acte_naissance.max'        => 'L\'acte de naissance ne doit pas dépasser 5 Mo.',
            'bulletin.mimes'            => 'Le bulletin doit être un PDF, JPG ou PNG.',
            'bulletin.max'              => 'Le bulletin ne doit pas dépasser 5 Mo.',
        ]);

        // Upload acte de naissance
        if ($request->hasFile('acte_naissance')) {
            $data['acte_naissance'] = $request->file('acte_naissance')
                ->store('preinscriptions/actes', 'public');
        }

        // Upload bulletin
        if ($request->hasFile('bulletin')) {
            $data['bulletin'] = $request->file('bulletin')
                ->store('preinscriptions/bulletins', 'public');
        }

        $data['statut'] = 'en_attente';
        Preinscription::create($data);

        return redirect(route('preinscription') . '#formulaire')
    ->with('success', 'Votre préinscription a bien été enregistrée ! Nous vous contacterons très prochainement.');
    }
}