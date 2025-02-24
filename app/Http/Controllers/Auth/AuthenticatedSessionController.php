<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use App\Models\User;
use App\Models\Employee;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $email = $request->input('email');

        // Căutăm utilizatorul în tabela `users`
        $user = User::where('email', $email)->first();
        $employee = null;

        // Dacă utilizatorul nu există în `users`, căutăm în `employees`
        if (!$user) {
            $employee = Employee::where('email', $email)->first();

            // Dacă nu există nici în `employees`, returnăm eroare
            if (!$employee) {
                return back()->withErrors(['email' => 'Nu există cont cu aceste date. Vă rugăm să solicitați crearea unuia.']);
            }

            // Tratarea statusului pentru Employee
            switch ($employee->status) {
                case 0:
                    return back()->withErrors(['email' => 'Înregistrarea dvs. a fost deja solicitată. Veți fi notificat odată ce contul dvs. este aprobat.']);
                case 2:
                    return back()->withErrors(['email' => 'Înregistrarea dvs. a fost respinsă.']);
            }

            // Autentificare pentru Employee
            Auth::guard('employee')->login($employee);

            // Regenerăm sesiunea
            $request->session()->regenerate();

            // Gestionăm redirecționarea pentru `employees`
            return redirect()->intended(route('employee.dashboard'));
        }

        // Tratarea statusului pentru User
        switch ($user->status) {
            case 0:
                return back()->withErrors(['email' => 'Înregistrarea dvs. a fost deja solicitată. Veți fi notificat odată ce contul dvs. este aprobat.']);
            case 2:
                return back()->withErrors(['email' => 'Înregistrarea dvs. a fost respinsă.']);
        }

        // Autentificare pentru User
        $request->authenticate();
        $request->session()->regenerate();

        // Redirecționare în funcție de rol
        if ($user->role === 'owner') {
            return redirect()->route('admin.dashboard');
        } elseif (in_array($user->role, ['super-admin', 'user'])) {
            session(['hotel_id' => $user->hotel_id]);
            return redirect()->intended(route('admin.management-hotel'));
        }

        return back()->withErrors(['email' => 'Rolul utilizatorului este invalid.']);
    }



    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
