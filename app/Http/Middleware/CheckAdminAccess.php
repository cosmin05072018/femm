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
        // Dacă utilizatorul nu este autentificat sau are status invalid, returnăm la ruta principală
        return redirect('fantastic-admin'); // Sau orice altă rută implicită
    }

    // Verificăm ruta curentă
    $currentRoute = $request->path(); // Obține ruta curentă relativă (ex: 'fantastic-admin')

    // Reguli pentru redirecționare în funcție de rol
    if ($currentRoute === 'fantastic-admin') {
        if (in_array($user->role, ['super-admin', 'admin'])) {
            // Redirect către management-hotel dacă este super-admin sau admin
            return redirect('fantastic-admin/management-hotel');
        } elseif ($user->role !== 'owner') {
            // Dacă rolul nu este permis, redirecționăm la o rută implicită
            return redirect('fantastic-admin')->with('error', 'Acces permis doar pentru owner.');
        }
    }

    if ($currentRoute === 'fantastic-admin/management-hotel' && !in_array($user->role, ['super-admin', 'admin'])) {
        // Dacă ruta este management-hotel și utilizatorul nu are rol permis
        return redirect('fantastic-admin')->with('error', 'Acces permis doar pentru super-admin sau admin.');
    }

    // Acces permis pentru cererea curentă
    return $next($request);
}

}
