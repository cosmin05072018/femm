<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Department;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class DepartmentFromHotelController extends Controller
{
    public function show($departmentId)
    {

        $authUser = Auth::user();
        // Găsim departamentul
        $department = Department::findOrFail($departmentId);

        // Obținem hotelurile asociate acestui departament
        $hotels = $department->hotels; // Poate fi mai multe hoteluri asociate departamentului

        // Verificăm dacă există cel puțin un hotel
        $hotel = $hotels->first(); // Folosim primul hotel din colecție, presupunând că sunt multiple hoteluri

        // Găsim utilizatorii care sunt în acest departament și au același hotel
        $users = User::where('department_id', $department->id)
                     ->where('hotel_id', $hotel ? $hotel->id : null) // Asigură-te că $hotel nu e null
                     ->get();


        return view('users.viewdepartment', compact('department', 'hotel', 'users', 'authUser'));
    }

    public function create(Request $request){
        dd(Auth::user()->hotel->name);

    }
}
