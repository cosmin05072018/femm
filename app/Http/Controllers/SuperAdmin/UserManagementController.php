<?php

namespace App\Http\Controllers\SuperAdmin;

use Illuminate\Support\Facades\Auth;
use Webklex\IMAP\Facades\Client;
use App\Models\User;
use App\Models\Hotel;
use App\Models\Department;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Http;
use App\Mail\MailForUserAccepted;
use PHPUnit\Framework\Attributes\Depends;

use function Ramsey\Uuid\v1;

class UserManagementController extends Controller
{
    // Metoda pentru a lista utilizatorii
    public function index()
    {
        // Preluăm toți utilizatorii din baza de date
        $users = User::all();
        $owner = User::where('role', 'owner')->first();

        // Returnăm view-ul cu lista utilizatorilor
        return view('superAdmin/usermanagement', compact('users', 'owner'));
    }

    public function accept(User $user)
    {
        $user->update(['status' => 1]);
        return redirect()->route('admin.users-management')->with('success', 'Utilizatorul a fost acceptat.');
    }

    public function acceptUser(Request $request, $id)
    {
        // dd($request->all());
        // dd($request->input('parola-femm'));
        // Găsim utilizatorul după ID
        $user = User::findOrFail($id);

        // Inserăm datele în tabela "hotels"
        $hotel = new Hotel();
        $hotel->name = $user->hotel_name; // Preluăm numele hotelului din tabela users
        $hotel->address = $user->company_address; // Preluăm adresa companiei din tabela users
        $hotel->save();

        // Actualizăm statusul și rolul utilizatorului
        $user->status = 1; // 1 = Aprobat
        $user->role = 'super-admin';
        $user->hotel_id = $hotel->id; // Asociem utilizatorul cu ID-ul hotelului
        $user->email_femm = $request->input('email-femm').'@femm.ro';
        $user->password_mail_femm = $request->input('parola-femm'); // Hashing parola
        $user->save();

        // date de logare pe mail care vor fi trimise in Mail creat automat
        $userMail = $request->input('email-femm');
        $userPasswordMail = $request->input('parola-femm');

        // Trimitem email utilizatorului
        Mail::to($user->email)->send(new MailForUserAccepted($user));

        // Crearea adresei de mail pe server
        // Validează datele introduse în formular
        $request->validate([
            'email-femm' => 'required|string',
            'parola-femm' => 'required|string|min:6',
        ]);

        // Construiește URL-ul pentru API-ul cPanel
        $cpanelHost = env('CPANEL_HOST');
        $cpanelUsername = env('CPANEL_USERNAME');
        $cpanelToken = env('CPANEL_API_TOKEN');

        $url = "https://$cpanelHost:2083/execute/Email/add_pop";

        // Parametrii pentru cererea API
        $params = [
            'email' => $request->input('email-femm'),
            'password' => $request->input('parola-femm'),
        ];

        // Efectuează cererea către API cu metoda POST
        $response = Http::withHeaders([
            'Authorization' => "cpanel $cpanelUsername:$cpanelToken",
        ])->post($url, $params);

        // Verifică răspunsul API
        if ($response->successful()) {
            // Afișează răspunsul pentru debugging în caz de succes
            // dd('Email creat cu succes:', $response->json());
        } else {
            // Afișează răspunsul pentru debugging în caz de eroare
            // dd('Eroare la crearea emailului:', $response->body());
        }

        // Redirectăm înapoi cu un mesaj de succes
        return redirect()->back()->with('success', 'Utilizatorul a fost aprobat și hotelul a fost adăugat.');
    }

    public function show(Request $request)
    {
        $hotelId = session('hotel_id');

        if (!$hotelId) {
            return;
        }

        // Obține hotelul după ID
        $hotel = Hotel::find($hotelId);

        // Verifică dacă hotelul există
        if (!$hotel) {
            return back()->with('error', 'Hotelul nu a fost găsit.');
        }

        // Preluăm utilizatorii aferenți hotelului
        $departments = Department::all();
        $users = User::where('hotel_id', $hotelId)->get();
        $authUser = Auth::user();

        $data = [
            'departments' => $departments,
            'users' => $users,
            'hotelName' => $hotel->name, // Trimite numele hotelului
        ];

        // Returnăm view-ul cu datele utilizatorilor și hotelului
        return view('users.same_hotel', compact('data'));
    }




    public function destroy($userId)
    {
        // Găsește utilizatorul pe baza ID-ului
        $user = User::findOrFail($userId);

        // Șterge utilizatorul
        $user->delete();

        // Redirectează înapoi cu un mesaj de succes
        return redirect()->back();
    }
}
