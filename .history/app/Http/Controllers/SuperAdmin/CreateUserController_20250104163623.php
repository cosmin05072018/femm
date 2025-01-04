<?php

namespace App\Http\Controllers\SuperAdmin;

use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Hotel;
use App\Models\Department;
use App\Models\Employee;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CreateUserController extends Controller
{
    public function create(Request $request)
    {
        $hotel = $request->id;
        $name = $request->name;
        $phone = $request->phone;
        $email = $request->email;
        $role_id = $request->role;
        $department_id = $request->department;

        return redirect()->back();
    }
}
