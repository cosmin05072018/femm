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
        $userId = $user->id;
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

        $messages = $inbox->messages()->all()->get();

        foreach ($messages as $message) {
            $flags = $message->flags();  // Obține colecția de flag-uri
            $message->is_seen = $flags->contains('Seen');  // Verifică dacă colecția conține flag-ul 'Seen'
        }


        // $idUserFromMail = User::where('email_femm', $account)->value('id');


        return view('superAdmin/emails', compact('owner', 'messages'));
    }

    public function show(Request $request)
    {
        // dd($request->email);
        $mailAdressView = $request->email;

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

        $messages = $inbox->query()->getMessage($request->email);
        return view('superAdmin/view-email', compact('owner', 'messages'));
    }

    public function reply(Request $request)
{
    $user = Auth::user();
    $userId = $user->id;
    $account = $user->email_femm;
    $password = $user->password_mail_femm;

    if (!$account) {
        return response()->json(['error' => 'Contul de email nu este configurat.'], 404);
    }

    // Connect to the IMAP server
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

    // Retrieve the message by UID
    $message = $inbox->query()->getMessage($request->email);

    try {
        // Creează răspunsul
        $reply = $message->reply();
        $reply->setTextBody($request->reply_message); // Mesajul răspunsului
        $reply->send(); // Trimite răspunsul
        // Debugging: Afișează un mesaj de confirmare
        dd('Răspunsul a fost trimis cu succes către: ' . $message->getFrom()[0]->mail);

    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'A apărut o eroare: ' . $e->getMessage());
    }


    return redirect()->back()->with('success', 'Răspunsul a fost trimis cu succes!');
}
}
