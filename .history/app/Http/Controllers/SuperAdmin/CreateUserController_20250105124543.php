<?php

namespace App\Http\Controllers\SuperAdmin;

use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Hotel;
use App\Models\Department;
use App\Models\Employee;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use GuzzleHttp\Client;

function createEmailAccountInCpanel($email, $password, $domain, $quota = 1024)
{
    $cpanelHost = env('CPANEL_HOST'); // Configurat în .env
    $cpanelUser = env('CPANEL_USER'); // Configurat în .env
    $cpanelPassword = env('CPANEL_PASSWORD'); // Configurat în .env

    $client = new Client([
        'base_uri' => $cpanelHost,
        'auth' => [$cpanelUser, $cpanelPassword],
    ]);

    try {
        $response = $client->request('POST', '/execute/Email/add_pop', [
            'form_params' => [
                'email' => $email,
                'password' => $password,
                'domain' => $domain,
                'quota' => $quota, // Quota în MB
            ],
        ]);

        $data = json_decode($response->getBody(), true);

        if (isset($data['status']) && $data['status'] == 1) {
            return true; // Succes
        } else {
            throw new \Exception($data['errors'][0] ?? 'Eroare necunoscută');
        }
    } catch (\Exception $e) {
        throw new \Exception("Eroare la crearea contului de e-mail: " . $e->getMessage());
    }
}


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
                'password' => 'required|string|min:8', // Adăugat validarea pentru parolă
            ]);

            $name = $validated['name'];
            $phone = $validated['phone'];
            $email = $validated['email'] . '@femm.ro'; // Adaugă sufixul automat
            $role_id = $validated['role'];
            $department_id = $validated['department'];
            $functie = $validated['functie'];
            $password = $validated['password']; // Stocăm parola validată

            Employee::create([
                'name' => $name,
                'phone' => $phone,
                'email' => $email,
                'role_id' => $role_id,
                'department_id' => $department_id,
                'function' => $functie,
                'password' => bcrypt($password), // Hashing parola
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
