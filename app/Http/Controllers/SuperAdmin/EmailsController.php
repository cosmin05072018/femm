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
use Webklex\PHPIMAP\Facade\IMAP;
use Webklex\PHPIMAP\Query\WhereQuery;

class EmailsController extends Controller
{
    // Metoda pentru a lista utilizatorii
    public function index()
    {

        $user = Auth::user();
        $owner = User::where('role', 'owner')->first();

        $account = $user->email_femm;
        $password = $user->password_mail_femm;

        if (!$account) {
            return response()->json(['error' => 'Contul de email nu este configurat.'], 404);
        }

        $client = Client::make([
            'host'          => 'mail.femm.ro',
            'port'          => 993,
            'encryption'    => 'ssl',
            'validate_cert' => true,
            'username'      => $account,
            'password'      => $password,
            'protocol'      => 'imap',
        ]);

        $client->connect();
        $inbox = $client->getFolder('INBOX');

        $unseenMessage = $inbox->query()->unseen()->get();
        $seenMessage = $inbox->query()->seen()->get();

        // $messages = $inbox->messages()->all()->get();

        $messages = $inbox->messages()->all()->get();

        foreach ($messages as $message) {
            // Verifică dacă mesajul a fost citit
            $isRead = $message->isSeen(); // În loc de getFlags(), folosește isSeen()

            // Adaugă la fiecare mesaj un câmp care indică dacă a fost citit
            $message->isRead = $isRead;
        }
        dd($message);


        return view('superAdmin/emails', compact('owner', 'messages'));
    }
}
