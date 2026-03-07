<?php

namespace App\Http\Controllers;

use App\Models\NewsletterSubscriber;
use Illuminate\Http\Request;

class NewsletterController extends Controller
{
    public function subscribe(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ], [
            'email.required' => 'Veuillez entrer votre adresse email.',
            'email.email' => 'Veuillez entrer une adresse email valide.',
        ]);

        $existe = NewsletterSubscriber::where('email', $request->email)->exists();

        if ($existe) {
            return back()->with('newsletter_info', 'Vous êtes déjà abonné à notre newsletter.');
        }

        NewsletterSubscriber::create([
            'email' => $request->email,
            'actif' => true,
        ]);

        return back()->with('newsletter_success', 'Merci ! Vous êtes bien abonné à notre newsletter.');
    }
}