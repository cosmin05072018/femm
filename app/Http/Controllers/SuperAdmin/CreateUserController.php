<?php

namespace App\Http\Controllers\SuperAdmin;

use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Hotel;
use App\Models\Department;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

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
                'password' => [
                    'required',
                    'string',
                    'min:8',
                    'regex:/^(?=.*[A-Z])(?=.*\d)(?=.*[\W_])[A-Za-z\d\W_]+$/'
                ],
            ], [
                'password.regex' => 'Parola trebuie să conțină cel puțin o literă mare, o cifră, un caracter special (@$!%*?&) și să aibă minim 8 caractere.',
            ]);


            $name = $validated['name'];
            $phone = $validated['phone'];

            // special email
            $nameModified = strtolower(str_replace(' ', '', $validated['name']));
            $departmentName = Department::find($validated['department']);
            $departmentNameForEmail = strtolower(str_replace(' ', '', $departmentName->name ?? ''));
            $email = "{$nameModified}.{$departmentNameForEmail}@femm.ro";
            dd($email);
            $role_id = $validated['role'];
            $department_id = $validated['department'];
            $functie = $validated['functie'];
            $password = $validated['password'];

            // Crearea angajatului în baza de date
            User::create([
                'employee_name' => $name,
                'phone' => $phone,
                'email' => $email,
                'role_id' => $role_id,
                'department_id' => $department_id,
                'function' => $functie,
                'password' => $password,
                'status' => 1,
                'hotel_id' => $hotel
            ]);

            // Crearea adresei de mail pe server
            $cpanelHost = env('CPANEL_HOST');
            $cpanelUsername = env('CPANEL_USERNAME');
            $cpanelToken = env('CPANEL_API_TOKEN');

            $url = "https://$cpanelHost:2083/execute/Email/add_pop";
            $params = [
                'email' => $emailPrefix, // Fără sufixul @femm.ro deoarece API-ul îl adaugă automat
                'password' => $password, // Parola originală
            ];

            $response = Http::withHeaders([
                'Authorization' => "cpanel $cpanelUsername:$cpanelToken",
            ])->post($url, $params);

            // Verificare dacă mailul a fost creat cu succes
            if (!$response->successful()) {
                return redirect()->to(route('admin.hotel.show', ['id' => $hotel]) . '#formular-angajati')
                    ->with('error', 'Angajatul a fost creat, dar adresa de email nu a fost generată.')
                    ->withInput();
            }

            return redirect()->to(route('admin.hotel.show', ['id' => $hotel]) . '#formular-angajati')
                ->with('success', 'Angajatul a fost creat și adresa de email a fost generată cu succes.');
        } catch (ValidationException $e) {
            return redirect()->to(route('admin.hotel.show', ['id' => $hotel]) . '#formular-angajati')
                ->withErrors($e->validator)
                ->withInput();
        }
    }
}
