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

class EmailsController extends Controller
{
    // Metoda pentru a lista utilizatorii
    public function index()
    {
        $owner = User::where('role', 'owner')->first();

        return view('superAdmin/emails', compact('owner'));
    }

}
