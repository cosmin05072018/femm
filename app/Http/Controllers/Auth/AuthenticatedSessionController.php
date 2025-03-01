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
        // Preluăm emailul din request
        $email = $request->input('email');

        // Căutăm în tabelă dacă există un utilizator cu acest email
        $user = User::where('email', $email)->first();

        // Dacă emailul nu există în tabelă, returnăm un mesaj de eroare specific
        if (!$user) {
            return back()->withErrors(['email' => 'Nu există cont cu aceste date. Vă rugăm să solicitați crearea unuia.']);
        }

        // Verificăm valoarea coloanei `status`
        switch ($user->status) {
            case 0:
                return back()->withErrors(['email' => 'Înregistrarea dvs. a fost deja solicitată. Veți fi notificat odată ce contul dvs. este aprobat.']);
            case 2:
                return back()->withErrors(['email' => 'Înregistrarea dvs. a fost respinsă.']);
        }

        // Continuăm autentificarea dacă emailul și statusul sunt valide
        $request->authenticate();

        // Regenerăm sesiunea după autentificare
        $request->session()->regenerate();

        // Actualizăm starea de conectare a utilizatorului
        if ($user) {
            // Obține instanța completă din baza de date
            $user = User::find($user->id);

            // Actualizează starea de deconectare
            $user->is_logged_in = 1;
            $user->save();
        }

        // Verificăm rolul utilizatorului
        if ($user->role_id === 1) {
            // Redirecționăm super-admin-ul către ruta '/fantastic-admin'
            return redirect()->route('admin.dashboard');
        } else {
            // Preia toți utilizatorii care aparțin aceluiași hotel_id ca utilizatorul curent
            $user = User::where('hotel_id', $user->hotel_id)
                ->with(['department', 'hotel'])
                ->first();  // Folosește `first()` pentru a obține un singur utilizator

            // Salvăm `hotel_id` în sesiune
            session(['hotel_id' => $user->hotel_id]);


            // Redirecționare către pagina fără a include `hotel_id` în URL
            return redirect()->intended(route('admin.management-hotel'));
        }

        // În cazul unui rol necunoscut, returnăm eroare
        return back()->withErrors(['email' => 'Rolul utilizatorului este invalid.']);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        // Preia utilizatorul curent
        $user = auth()->user();

        // Verifică dacă utilizatorul este autentificat și apoi actualizează
        if ($user) {
            // Obține instanța completă din baza de date
            $user = User::find($user->id);

            // Actualizează starea de deconectare
            $user->is_logged_in = 0;
            $user->save();
        }

        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
