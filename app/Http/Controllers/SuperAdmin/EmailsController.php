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

        $htmlBody = $messages->getHTMLBody();

        // Preia atașamentele
        $attachments = $messages->getAttachments();

        if ($attachments->count() > 0) {
            // Creează o secțiune pentru atașamente
            $htmlBody .= '<div class="attachments">';
            $htmlBody .= '<h4>Atașamente:</h4>';

            foreach ($attachments as $attachment) {
                // Salvează fiecare atașament
                $path = 'emails/';
                $filename = $attachment->getName();
                $attachment->save(storage_path("app/public/$path"), $filename);

                // Creează URL public pentru atașament
                $url = Storage::url("$path$filename");

                // Adaugă un link sau imagine pentru atașament în HTML
                if (preg_match('/\.(jpg|jpeg|png|gif)$/i', $filename)) {
                    // Dacă este o imagine, o afișăm
                    $htmlBody .= "<div><img src='$url' alt='$filename' style='max-width:100%; height:auto;'></div>";
                } else {
                    // Dacă este alt tip de fișier, afișăm un link de descărcare
                    $htmlBody .= "<div><a href='$url' download>$filename</a></div>";
                }
            }

            $htmlBody .= '</div>';
        }


        return view('superAdmin/view-email', compact('owner', 'messages'));
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
