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

class EmailsController extends Controller
{
    // Metoda pentru a lista utilizatorii
    public function index()
    {

        $user = Auth::user();
        $userId = $user->id;
        $owner = User::where('role', 'owner')->first();
        $emails = Email::where('user_id', $userId)
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


        if (!$account) {
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

        // Găsește mesajul original
        $message = $inbox->query()->getMessage($request->email);

        if (!$message) {
            return response()->json(['error' => 'Mesajul nu a fost găsit.'], 404);
        }

        // Setează detaliile mesajului de răspuns
        $replyTo = $message->getFrom()[0]->mail; // E-mailul destinatarului
        $subject = 'Re: ' . $message->getSubject(); // Subiectul răspunsului
        $replyMessage = $request->reply_message; // Mesajul de răspuns

        // Trimite răspunsul folosind Mail
        Mail::raw($replyMessage, function ($mail) use ($replyTo, $subject, $account) {
            $mail->to($replyTo)
                ->from($account)
                ->subject($subject);
        });

        return redirect()->back()->with('success', 'Răspunsul a fost trimis cu succes!');
    }
}
