<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckAdminAccess
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

        // Dacă nu e logat, redirecționează către login, NU înapoi la fantastic-admin
        if (!$user) {
            return redirect('/login');
        }

        // Dacă nu are status activ
        if ($user->status !== 1) {
            abort(403, 'Cont inactiv');
        }

        // Verificăm ruta curentă
        $currentRoute = $request->path();

        // Redirecționări specifice
        if ($currentRoute === 'fantastic-admin') {
            if (in_array($user->role_id, [2, 3, 4])) {
                return redirect('fantastic-admin/management-hotel');
            } elseif ($user->role_id !== 1) {
                abort(403, 'Acces permis doar pentru owner.');
            }
        }

        if ($currentRoute === 'fantastic-admin/management-hotel' && !in_array($user->role_id, [2, 3, 4])) {
            abort(403, 'Acces permis doar pentru super-admin sau admin.');
        }

        return $next($request);
    }
}
