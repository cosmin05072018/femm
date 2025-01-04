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

        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'phone' => 'required|string|max:20|unique:employees,phone',
                'email' => 'required|string|max:255|unique:employees,email',
                'role' => 'required|exists:roles,id',
                'functie' => 'required|string|max:255',
                'department' => 'required|exists:departments,id',
            ]);

            $name = $validated['name'];
            $phone = $validated['phone'];
            $email = $validated['email'] . '@femm.ro'; // Adaugă sufixul automat
            $role_id = $validated['role'];
            $department_id = $validated['department'];

            Employee::create([
                'name' => $name,
                'phone' => $phone,
                'email' => $email,
                'role_id' => $role_id,
                'department_id' => $department_id,
                'hotel_id' => $hotel
            ]);

            return redirect()->to(route('admin.hotel.show', ['id' => $hotel]) . '#formular-angajati');
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Capturează erorile de validare și redirecționează cu hash-ul formularului
            return redirect()->to(route('admin.hotel.show', ['id' => $hotel]) . '#formular-angajati')
                ->withErrors($e->validator)
                ->withInput();
        }
    }
}
