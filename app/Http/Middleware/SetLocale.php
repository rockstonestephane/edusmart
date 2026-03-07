<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class SetLocale
{
    public function handle(Request $request, Closure $next)
    {
        // Priorité 1 : segment URL (/fr/ ou /en/)
        $segment = $request->segment(1);

        if (in_array($segment, ['fr', 'en'])) {
            $locale = $segment;
            Session::put('locale', $locale);
        }
        // Priorité 2 : session
        elseif (Session::has('locale')) {
            $locale = Session::get('locale');
        }
        // Priorité 3 : défaut français
        else {
            $locale = 'fr';
        }

        App::setLocale($locale);

        return $next($request);
    }
}