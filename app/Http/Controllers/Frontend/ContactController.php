<?php
namespace App\Http\Controllers\Frontend;
use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Models\PageHero;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index($locale)
    {
        $hero = PageHero::getForPage('contact');
        return view('frontend.pages.contact', compact('hero'));
    }

    public function send(Request $request, $locale)
    {
        $data = $request->validate([
            'nom'     => 'required|string|max:100',
            'email'   => 'required|email|max:100',
            'sujet'   => 'required|string|max:200',
            'message' => 'required|string|max:2000',
        ], [
            'nom.required'     => 'Votre nom est obligatoire.',
            'email.required'   => 'Votre email est obligatoire.',
            'email.email'      => "L'adresse email n'est pas valide.",
            'sujet.required'   => 'Le sujet est obligatoire.',
            'message.required' => 'Le message est obligatoire.',
        ]);

        Contact::create($data);

        return redirect(lroute('contact') . '#formulaire')
            ->with('success', 'Votre message a bien été envoyé ! Nous vous répondrons dans les plus brefs délais.');
    }
}