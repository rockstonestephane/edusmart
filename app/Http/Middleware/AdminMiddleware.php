<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Vérifie que l'utilisateur connecté est bien un admin.
     * Le champ `is_admin` doit exister dans la table users.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Pas connecté → redirige vers le login admin
        if (!auth()->check()) {
            return redirect()->route('admin.login')
                ->with('error', 'Veuillez vous connecter pour accéder à l\'espace admin.');
        }

        // Connecté mais pas admin → redirige vers l'accueil
        if (!auth()->user()->is_admin) {
            abort(403, 'Accès refusé. Vous n\'êtes pas administrateur.');
        }

        return $next($request);
    }
}