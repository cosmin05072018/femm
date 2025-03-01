<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Department;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\HotelDepartment;
use App\Models\ChatGroup;

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

    protected $names = ['nivel1', 'nivel2', 'nivel3'];

    public function createChatGroupLevel1()
    {
        $hotel_id = Auth::user()->hotel_id;
        $departments = HotelDepartment::where('hotel_id', $hotel_id)
            ->with('department')
            ->get();

        foreach ($departments as $department) {
            ChatGroup::create([
                'hotel_id' => $hotel_id,
                'department_id' => $department->department_id,
                'name' => $this->names[0],
            ]);
        }

        return redirect()->back()->with('success', 'Chat groups created successfully.');
    }

    public function viewchat()
    {
        $hotel_id = Auth::user()->hotel_id;

        // Găsim toate departamentele asociate hotelului în tabela chat_groups
        $departmentIds = ChatGroup::where('hotel_id', $hotel_id)
            ->pluck('department_id');

        // Găsim utilizatorii care sunt în același hotel și în aceste departamente
        $users = User::where('hotel_id', $hotel_id)
            ->whereIn('department_id', $departmentIds)
            ->get();
        dd($users);
        return redirect()->back();
    }
}
