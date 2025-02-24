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
        if (!$user || (isset($user->status) && $user->status !== 1)) {
            return redirect('fantastic-admin');
        }

        // Verificăm ruta curentă
        $currentRoute = $request->path(); // Obține ruta curentă relativă

        // Verificăm dacă utilizatorul trebuie redirecționat, dar **numai dacă nu e deja acolo**
        if ($currentRoute === 'fantastic-admin' && in_array($user->role, ['super-admin', 'admin', 'user'])) {
            return redirect()->route('admin.management-hotel');
        }

        if ($currentRoute === 'fantastic-admin/management-hotel' && !in_array($user->role, ['super-admin', 'admin', 'user'])) {
            return redirect('fantastic-admin')->with('error', 'Acces permis doar pentru super-admin, admin sau user.');
        }

        return $next($request);
    }
}
