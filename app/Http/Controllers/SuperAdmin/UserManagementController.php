<?php

namespace App\Http\Controllers\SuperAdmin;

use Illuminate\Support\Facades\Auth;
use Webklex\IMAP\Facades\Client;
use App\Models\User;
use App\Models\Hotel;
use App\Models\Department;
use App\Models\ChatGroup;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Http;
use App\Mail\MailForUserAccepted;
use PHPUnit\Framework\Attributes\Depends;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;


use function Ramsey\Uuid\v1;

class UserManagementController extends Controller
{
    // Metoda pentru a lista utilizatorii
    public function index()

    {
        // Preluăm toți utilizatorii din baza de date
        $users = User::all();
        $owner = auth()->user()->role_id === 1 ? auth()->user() : null;

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
        // Găsim utilizatorul după ID
        $user = User::findOrFail($id);

        // Inserăm datele în tabela "hotels"
        $hotel = new Hotel();
        $hotel->name = $user->hotel_name; // Preluăm numele hotelului din tabela users
        $hotel->address = $user->company_address; // Preluăm adresa companiei din tabela users
        $hotel->save();

        // **Adăugăm automat toate departamentele existente în hotel_department**
        $departments = Department::all(); // Obținem toate departamentele
        foreach ($departments as $department) {
            DB::table('hotel_department')->insert([
                'hotel_id' => $hotel->id,
                'department_id' => $department->id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Actualizăm statusul și rolul utilizatorului
        $user->status = 1; // 1 = Aprobat
        $user->role_id = 2;
        $user->hotel_id = $hotel->id; // Asociem utilizatorul cu ID-ul hotelului
        $user->email_femm = $request->input('email-femm') . '@femm.ro';
        $user->password_mail_femm = $request->input('parola-femm'); // Hashing parola
        $user->save();

        // Trimitem email utilizatorului
        Mail::to($user->email)->send(new MailForUserAccepted($user));

        // Crearea adresei de mail pe server
        $request->validate([
            'email-femm' => 'required|string',
            'parola-femm' => 'required|string|min:6',
        ]);

        $cpanelHost = env('CPANEL_HOST');
        $cpanelUsername = env('CPANEL_USERNAME');
        $cpanelToken = env('CPANEL_API_TOKEN');

        $url = "https://$cpanelHost:2083/execute/Email/add_pop";
        $params = [
            'email' => $request->input('email-femm'),
            'password' => $request->input('parola-femm'),
        ];

        $response = Http::withHeaders([
            'Authorization' => "cpanel $cpanelUsername:$cpanelToken",
        ])->post($url, $params);

        return redirect()->back()->with('success', 'Utilizatorul a fost aprobat, hotelul a fost adăugat și departamentele au fost asociate.');
    }


    public function show(Request $request)
    {

        dd(route('admin.department.users.create-chat-nivel1'));

        $authUser = Auth::user();

        // Obținem ID-ul hotelului utilizatorului autentificat
        $hotelId = $authUser->hotel_id;

        $existsChatGroup = ChatGroup::where('hotel_id', $hotelId)->exists();

        // Verificăm rolul utilizatorului și returnăm departamentele corespunzătoare
        if ($authUser->role_id == 2) {
            // Manager - toate departamentele din același hotel
            $departments = Department::whereHas('hotels', function ($query) use ($hotelId) {
                $query->where('hotel_id', $hotelId);
            })->withCount(['users' => function ($query) use ($hotelId) {
                $query->where('hotel_id', $hotelId);
            }])->get();
        } elseif (in_array($authUser->role_id, [3, 4])) {
            // Alți utilizatori - doar departamentul propriu
            $departments = Department::where('id', $authUser->department_id)
                ->whereHas('hotels', function ($query) use ($hotelId) {
                    $query->where('hotel_id', $hotelId);
                })->withCount(['users' => function ($query) use ($hotelId) {
                    $query->where('hotel_id', $hotelId);
                }])->get();
        }

        return view('users.same_hotel', compact('authUser', 'departments', 'existsChatGroup'));
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
