<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Hotel;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class FantasticAdminController extends Controller
{
    public function index()
    {

        $owner = User::where('role_id', 1)->first();

        $totalUsers = User::count(); // Numărul total de utilizatori
        $inactiveUsers = User::where('status', 0)->count(); // Utilizatori cu status = 0
        $totalDepartments = Department::count(); // Numărul total de departamente
        $totalHotels = Hotel::count(); // Numărul total de hoteluri

        // Construirea array-ului
        $data = [
            'total_users' => $totalUsers,
            'inactive_users' => $inactiveUsers,
            'total_departments' => $totalDepartments,
            'total_hotels' => $totalHotels,
        ];

        $statusUsersForChart = [
            'waiting' => User::where('status', 0)->count(),
            'accepted' => User::where('status', 1)->count(),
            'rejected' => User::where('status', 2)->count(),
        ];

        // Pasăm datele necesare în view
        return view('superAdmin/index', compact('owner', 'data', 'statusUsersForChart'));
    }

    public function destroy(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate(); // Invalidăm sesiunea
        $request->session()->regenerateToken(); // Regenerăm token-ul CSRF
        return redirect('/login'); // Redirecționare către pagina de login
    }
}
