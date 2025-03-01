<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Department;
use App\Models\User;

class DepartmentFromHotelController extends Controller
{
    public function show($departmentId)
    {
        // Găsim departamentul după ID
        $department = Department::findOrFail($departmentId);

        // Găsim utilizatorii care sunt în departamentul respectiv și care au același hotel
        $users = User::where('department_id', $department->id)
                     ->where('hotel_id', $department->hotel_id) // presupunând că utilizatorii au un hotel_id
                     ->get();

        return view('users.viewdepartment', compact('department', 'users'));
    }
}
