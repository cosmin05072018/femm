<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Hotel;
use App\Models\Department;
use App\Models\Role;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class HotelsController extends Controller
{
    public function index()
    {
        $owner = auth()->user()->role_id === 1 ? auth()->user() : null;
        $hotels = Hotel::all();

        $hotelsWithEmployeeCount = $hotels->map(function ($hotel) {
            $hotel->employee_count = Employee::where('hotel_id', $hotel->id)->count(); // Calculăm angajații
            return $hotel;
        });

        return view('superAdmin/hotels', compact('owner', 'hotelsWithEmployeeCount'));
    }

    public function show(Request $request)
    {
        $owner = auth()->user()->role_id === 1 ? auth()->user() : null;
        $hotelSelected = Hotel::where('id', $request->id)->first();
        $users = User::where('hotel_id', $request->id)
        ->where('id', '=', auth()->id()) // Exclude utilizatorul logat, dacă e necesar
        ->get();
        $departments = Department::all();
        $employees = User::where('hotel_id', $request->id)->get();
        $roles = Role::whereIn('name', ['admin', 'user'])->get();

        return view('superAdmin/hotel', compact('owner', 'users', 'hotelSelected', 'departments', 'roles', 'employees'));
    }

    public function destroy(Request $request)
    {

        $hotelId = $request->id; // Obținem ID-ul din cerere
        $hotel = Hotel::findOrFail($hotelId); // Căutăm hotelul cu ID-ul respectiv

        $hotel->delete(); // Ștergem hotelul

        return redirect()->route('admin.hotels');
    }
}
