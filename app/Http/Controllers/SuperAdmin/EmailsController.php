<?php

namespace App\Http\Controllers\SuperAdmin;

use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Email;
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
use Webklex\PHPIMAP\ClientManager;
use Illuminate\Support\Facades\Storage;
use Webklex\PHPIMAP\Message;

class EmailsController extends Controller
{
    // Metoda pentru a lista utilizatorii
    public function index()
    {

        $user = Auth::user();
        $userId = $user->id;
        $owner = User::where('role', 'owner')->first();
        $emails = Email::where('user_id', $userId)
            ->where('type', 'received')  // Verifică că această condiție funcționează
            ->orderByDesc('created_at') // Sortează de la cel mai nou la cel mai vechi
            ->get();



        return view('superAdmin/emails', compact('owner', 'emails'));
    }

    public function show(Request $request)
    {

        $mailAdressView = $request->email;
        Email::where('id', $mailAdressView)
            ->update(['is_seen' => 1]);


        $owner = User::where('role', 'owner')->first();
        $message = Email::where('id', $mailAdressView)->first();

        return view('superAdmin/view-email', compact('owner', 'message'));
    }




    public function reply(Request $request)
    {
        $user = Auth::user();
        $account = $user->email_femm;
        $password = $user->password_mail_femm;

        if (!$account || !$password) {
            return response()->json(['error' => 'Contul de email nu este configurat.'], 404);
        }

        // Conectare la serverul IMAP
        $clientManager = new ClientManager();
        $client = $clientManager->make([
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

        // UID-ul e-mailului la care vrei să răspunzi (primit din request)
        $uid = $request->input('uid');

        if (!$uid) {
            return response()->json(['error' => 'UID-ul e-mailului nu a fost specificat.'], 400);
        }

        // Caută e-mailul după UID
        $message = $inbox->query()->uid($uid)->get()->first();

        if (!$message) {
            return response()->json(['error' => 'E-mailul nu a fost găsit.'], 404);
        }

        // Obține detaliile e-mailului original
        $fromEmail = $message->getFrom()[0]->mail;
        $originalSubject = $message->getSubject();
        $originalBody = $message->getTextBody();

        // Compune mesajul de răspuns
        $replySubject = "Re: " . $originalSubject;
        $replyBody = $request->input('message'); // Mesajul nou trimis de utilizator

        if (!$replyBody) {
            return response()->json(['error' => 'Conținutul răspunsului este gol.'], 400);
        }

        // Trimiterea e-mailului de răspuns
        Mail::raw($replyBody, function ($mail) use ($fromEmail, $replySubject, $account) {
            $mail->to($fromEmail)
                ->from($account)
                ->subject($replySubject);
        });

        return response()->json(['success' => 'Răspunsul a fost trimis cu succes.']);
    }
}
