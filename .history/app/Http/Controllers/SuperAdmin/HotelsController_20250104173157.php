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
        $owner = User::where('role', 'owner')->first();
        $hotels = Hotel::all();

        return view('superAdmin/hotels', compact('owner', 'hotels'));
    }

    public function show(Request $request)
    {
        $owner = User::where('role', 'owner')->first();
        $hotelSelected = Hotel::where('id', $request->id)->first();
        $users = User::where('hotel_id', $request->id)->get();
        $departments = Department::all();
        $roles = Role::whereIn('name', ['admin', 'user'])->get();

        return view('superAdmin/hotel', compact('owner', 'users', 'hotelSelected', 'departments', 'roles'));
    }
}
