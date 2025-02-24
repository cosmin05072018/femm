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
use Exception;

class EmailsController extends Controller
{
    // Metoda pentru a lista utilizatorii
    public function index()
    {
        $user = Auth::user();
        $userId = $user->id;
        $owner = auth()->user()->role === 'owner' ? auth()->user() : null;

        // Mesaje primite
        $receivedEmails = Email::where('user_id', $userId)
            ->where('type', 'received')
            ->orderByDesc('created_at')
            ->get();

        // Mesaje necitite
        $unreadEmails = Email::where('user_id', $userId)
            ->where('is_seen', 0)
            ->orderByDesc('created_at')
            ->get();

        // Mesaje trimise
        $sentEmails = Email::where('user_id', $userId)
            ->where('type', 'sent')
            ->orderByDesc('created_at')
            ->get();

        return view('superAdmin/emails', compact('owner', 'receivedEmails', 'unreadEmails', 'sentEmails'));
    }


    public function show(Request $request)
    {

        $mailAdressView = $request->email;
        Email::where('id', $mailAdressView)
            ->update(['is_seen' => 1]);


        $owner = auth()->user()->role === 'owner' ? auth()->user() : null;
        $message = Email::where('id', $mailAdressView)->first();

        return view('superAdmin/view-email', compact('owner', 'message'));
    }

    public function send(Request $request)
{
    $user = Auth::user();
    $account = $user->email_femm;
    $password = $user->password_mail_femm;

    if (!$account) {
        return response()->json(['error' => 'Contul de email nu este configurat.'], 404);
    }

    $request->validate([
        'recipient' => 'required|email',
        'subject' => 'required|string',
        'message' => 'required|string',
        'attachment' => 'nullable|file|max:10240', // 10MB max
    ]);

    $recipient = $request->recipient;
    $subject = $request->subject;
    $messageBody = $request->message;
    $attachmentsData = [];

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

    // Gestionare atașament
    if ($request->hasFile('attachment')) {
        try {
            $file = $request->file('attachment');
            $filename = time() . '-' . $file->getClientOriginalName();
            $path = "emails/attachments/{$user->id}/" . $filename;
            Storage::disk('public')->put($path, file_get_contents($file));
            $attachmentsData[] = $path;
        } catch (Exception $e) {
            return response()->json(['error' => 'Eroare la salvarea atașamentului.'], 500);
        }
    }

    // Trimitere email folosind Symfony Mime
    Mail::send([], [], function ($mail) use ($recipient, $subject, $messageBody, $account, $attachmentsData) {
        $email = (new MimeEmail())
            ->from($account)
            ->to($recipient)
            ->subject($subject)
            ->text($messageBody)
            ->html(new TextPart($messageBody, 'utf-8', 'html'));

        foreach ($attachmentsData as $filePath) {
            $email->attachFromPath(storage_path("app/public/" . $filePath));
        }

        $mail->setSymfonyMessage($email);
    });

    // Salvare email trimis în baza de date
    Email::create([
        'user_id'   => $user->id,
        'message_id' => uniqid(),
        'from'      => $account,
        'to'        => $recipient,
        'subject'   => $subject,
        'body'      => $messageBody,
        'is_seen'   => false,
        'type'      => 'sent',
        'attachments' => json_encode($attachmentsData),
    ]);

    return redirect()->back()->with('success', 'Emailul a fost trimis cu succes!');
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
        // Obține toate mesajele (sau poți folosi recent(), unread() etc.)
        $messages = $inbox->query()->all()->get();

        $uids = '';
        foreach ($messages as $message) {
            $uids = (int) $message->getUid(); // Convertim UID-ul la int
        }

        // Găsește mesajul original
        $message = $inbox->query()->getMessage($uids);
        // dd($message);

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

        // Salvează emailul trimis în baza de date
        Email::create([
            'user_id'   => $user->id, // ID-ul utilizatorului
            'message_id' => uniqid(), // ID unic pentru mesajul trimis (poți utiliza un alt ID relevant)
            'from'      => $account,
            'to'        => $replyTo,
            'subject'   => $subject,
            'body'      => $replyMessage,
            'is_seen'   => false,
            'type'      => 'sent', // Setează tipul la 'sent'
            'attachments' => json_encode([]), // Dacă sunt atașamente, le poți adăuga aici, altfel lasă un array gol
        ]);

        return redirect()->back()->with('success', 'Răspunsul a fost trimis cu succes!');
    }
}
