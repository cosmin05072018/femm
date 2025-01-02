<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Manejează cererea.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        if ($user && $user->status === 1) {
            // Dacă utilizatorul este super-admin, redirecționează către /fantastic-events
            if ($user->role === 'super-admin') {
                return redirect('/fantastic-admin');
            }

            // Dacă utilizatorul este admin sau user, redirecționează către /hotel-manager
            if (in_array($user->role, ['admin', 'user'])) {
                return redirect('/hotel-manager');
            }
        }

        // Continuă procesarea cererii pentru utilizatorii neautentificați sau fără condiții speciale
        return $next($request);
    }
}
