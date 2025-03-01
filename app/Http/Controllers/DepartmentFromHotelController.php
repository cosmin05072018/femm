<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Department;
use App\Models\User;

class DepartmentFromHotelController extends Controller
{
    public function show($departmentId)
    {
        $department = Department::findOrFail($departmentId);

        // Obținem hotelurile asociate acestui departament
        $hotels = $department->hotels; // Poate fi mai multe hoteluri asociate departamentului

        // Verificăm dacă există cel puțin un hotel
        $hotel = $hotels->first(); // Folosim primul hotel din colecție, presupunând că sunt multiple hoteluri

        // Găsim utilizatorii care sunt în acest departament și au același hotel
        $users = User::where('department_id', $department->id)
            ->where('hotel_id', $hotel->id) // Asumăm că fiecare utilizator are un hotel_id
            ->get();

        dd($department['name']);

        return view('users.viewdepartment', compact('department', 'users'));
    }
}
