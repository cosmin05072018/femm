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

        // Verificăm dacă utilizatorul este autentificat și are status = 1
        if (!$user || $user->status !== 1) {
            return redirect('fantastic-admin');
        }

        // Verificăm ruta curentă
        $currentRoute = $request->path();

        // Reguli pentru redirecționare în funcție de rol_id
        if ($currentRoute === 'fantastic-admin') {
            if (in_array($user->role_id, [1])) { // super-admin (2) sau admin (3)
                return redirect('fantastic-admin/management-hotel');
            // } elseif ($user->role_id !== 1) { // Nu este owner (1)
            //     return redirect('fantastic-admin')->with('error', 'Acces permis doar pentru owner.');
            }
        }

        // if ($currentRoute === 'fantastic-admin/management-hotel' && !in_array($user->role_id, [2, 3, 4])) {
        //     return redirect('fantastic-admin')->with('error', 'Acces permis doar pentru super-admin sau admin.');
        // }

        return $next($request);
    }
}
