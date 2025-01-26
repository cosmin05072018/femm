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

        $attachments = $messages->getAttachments();
        $cidMap = [];

        foreach ($attachments as $attachment) {
            if ($attachment->getContentId()) {
                $cid = $attachment->getContentId();
                $base64Image = 'data:' . $attachment->getContentType() . ';base64,' . base64_encode($attachment->getContent());
                $cidMap[$cid] = $base64Image;
            }
        }

        $htmlBody = $messages->getHTMLBody();

        foreach ($cidMap as $cid => $base64Image) {
            $htmlBody = str_replace('cid:' . $cid, $base64Image, $htmlBody);
        }

        return view('superAdmin/view-email', compact('owner', 'htmlBody'));
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
