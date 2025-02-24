<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckAdminAccess
{
    public function handle(Request $request, Closure $next)
    {
        // Verificăm utilizatorul autenticat (fie User, fie Employee)
        $user = Auth::user() ?? Auth::guard('employees')->user();

        // Dacă nu există utilizator autentificat, redirecționăm la login
        if (!$user) {
            return redirect('fantastic-admin')->with('error', 'Trebuie să fii autentificat.');
        }

        // Dacă modelul are atributul "status" și nu este 1, blocăm accesul
        if (isset($user->status) && $user->status !== 1) {
            return redirect('fantastic-admin')->with('error', 'Acces restricționat.');
        }

        // Verificăm ruta curentă
        $currentRoute = $request->path();

        // Verificăm rolul și redirecționăm
        if ($currentRoute === 'fantastic-admin' && in_array($user->role, ['super-admin', 'admin', 'user'])) {
            return redirect()->route('admin.management-hotel');
        }

        if ($currentRoute === 'fantastic-admin/management-hotel' && !in_array($user->role, ['super-admin', 'admin', 'user'])) {
            return redirect('fantastic-admin')->with('error', 'Acces permis doar pentru super-admin, admin sau user.');
        }

        return $next($request);
    }
}
