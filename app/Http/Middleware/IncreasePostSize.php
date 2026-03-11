<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class IncreasePostSize
{
    public function handle(Request $request, Closure $next)
    {
        // Forcer les limites au runtime
        ini_set('post_max_size', '128M');
        ini_set('upload_max_filesize', '128M');
        
        return $next($request);
    }
}