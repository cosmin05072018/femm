<?php

namespace App\Http\Controllers\SuperAdmin;

use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Hotel;
use App\Models\Department;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use PHPUnit\Framework\Attributes\Depends;
use Webklex\IMAP\Facades\Client;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Http;
use function Ramsey\Uuid\v1;

class EmailsController extends Controller
{
    // Metoda pentru a lista utilizatorii
    public function index()
    {

        $user = Auth::user();
        dd($user->email_femm);
        $owner = User::where('role', 'owner')->first();

        $account = 'anonimanonimus330@femm.ro';
        if (!$account) {
            return response()->json(['error' => 'Contul de email nu este configurat.'], 404);
        }

        $client = Client::make([
            'host'          => 'mail.femm.ro',
            'port'          => 993,
            'encryption'    => 'ssl',
            'validate_cert' => true,
            // 'username'      => $account->email,
            'username'      => $account,
            // 'password'      => Crypt::decryptString($account->password),
            'password'      => 'bpBo1+H]ynKU',
            'protocol'      => 'imap',
        ]);

        $client->connect();
        $inbox = $client->getFolder('INBOX');
        $messages = $inbox->messages()->all()->get();

        return view('emails.index', compact('messages'));

        return view('superAdmin/emails', compact('owner'));
    }

}
