<?php

namespace App\Http\Controllers\SuperAdmin;

use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Hotel;
use App\Models\Department;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\UserAccepted;
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

    public function acceptUser($id)
    {
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
        $user->save();

        // Trimitem email utilizatorului
        Mail::to($user->email)->send(new UserAccepted($user));

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

        // Returnăm view-ul cu datele utilizatorilor și hotelului
        return view('users.same_hotel', $data[
            'departments' => $departments,
            'users' => $users,
            'authUser' => $authUser,
            'hotelName' => $hotel->name, // Trimite numele hotelului
        ]);
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
