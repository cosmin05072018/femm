<?php

namespace App\Http\Controllers\SuperAdmin;

use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Hotel;
use App\Models\Department;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use PHPUnit\Framework\Attributes\Depends;

use function Ramsey\Uuid\v1;

class DepartmentsController extends Controller
{
    // Metoda pentru a lista utilizatorii
    public function index()
    {
        // Preluăm toți utilizatorii din baza de date
        $departments = Department::all();
        $owner = User::where('role', 'owner')->first();

        // Returnăm view-ul cu lista utilizatorilor
        return view('superAdmin/departments', compact('departments', 'owner'));
    }

    public function ChangeColorDepartments(Request $request)
    {
        $department = Department::find($request->department_id);

        if ($department) {
            // Actualizare culoare
            $department->color = $request->color;
            $department->save();

            return redirect()->back()->with('success', 'Culoarea departamentului a fost actualizată!');
        }

        return redirect()->back()->with('error', 'Departamentul nu a fost găsit.');
    }
}
