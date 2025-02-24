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
use Symfony\Component\Mime\Email as MimeEmail;
use Symfony\Component\Mime\Part\TextPart;
use Illuminate\Support\Facades\Log;


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
        // Validare input
        $validated = $request->validate([
            'recipient'  => 'required|email',
            'cc'         => 'nullable|string', // Acceptă o listă de adrese separate prin virgulă
            'subject'    => 'required|string',
            'message'    => 'required|string',
            'attachment' => 'nullable|array',
            'attachment.*' => 'file'
        ]);

        $user = Auth::user();
        $account = $user->email_femm;

        if (!$account) {
            return response()->json(['error' => 'Contul de email nu este configurat.'], 404);
        }

        $recipient   = $request->input('recipient');
        $ccAddresses = $request->input('cc') ? explode(',', $request->input('cc')) : []; // Convertim lista CC în array
        $subject     = $request->input('subject');
        $messageBody = $request->input('message');

        // Gestionare atașamente
        $attachmentPaths = [];
        if ($request->hasFile('attachment')) {
            foreach ($request->file('attachment') as $attachmentFile) {
                $attachmentPath = $attachmentFile->storeAs('attachments', $attachmentFile->getClientOriginalName(), 'public');
                if ($attachmentPath) {
                    $attachmentPaths[] = $attachmentPath;
                }
            }
        }

        try {
            // Trimiterea emailului
            Mail::raw($messageBody, function ($mail) use ($recipient, $ccAddresses, $subject, $account, $attachmentPaths) {
                $mail->to($recipient)
                    ->from($account)
                    ->subject($subject);

                // Adăugăm destinatarii CC
                if (!empty($ccAddresses)) {
                    $mail->cc($ccAddresses);
                }

                // Atașăm fiecare fișier
                foreach ($attachmentPaths as $attachmentPath) {
                    $fullAttachmentPath = storage_path('app/public/' . $attachmentPath);
                    $attachmentContent = file_get_contents($fullAttachmentPath);

                    $mail->attachData($attachmentContent, basename($fullAttachmentPath), [
                        'mime' => mime_content_type($fullAttachmentPath),
                    ]);
                }
            });
        } catch (\Exception $e) {
            Log::error('Trimiterea emailului a eșuat: ' . $e->getMessage());
            return response()->json(['error' => 'Trimiterea emailului a eșuat.'], 500);
        }

        // Salvarea emailului în baza de date
        Email::create([
            'user_id'     => $user->id,
            'message_id'  => uniqid(),
            'from'        => $account,
            'to'          => $recipient,
            'cc'          => json_encode($ccAddresses),
            'subject'     => $subject,
            'body'        => $messageBody,
            'is_seen'     => false,
            'type'        => 'sent',
            'attachments' => json_encode($attachmentPaths),
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
        // Obține toate mesajele
        $messages = $inbox->query()->all()->get();

        $uids = '';
        foreach ($messages as $message) {
            $uids = (int) $message->getUid(); // Convertim UID-ul la int
        }

        // Găsește mesajul original
        $message = $inbox->query()->getMessage($uids);

        if (!$message) {
            return response()->json(['error' => 'Mesajul nu a fost găsit.'], 404);
        }

        // Setează detaliile mesajului de răspuns
        $replyTo = $message->getFrom()[0]->mail; // E-mailul destinatarului
        $subject = 'Re: ' . $message->getSubject(); // Subiectul răspunsului
        $replyMessage = $request->reply_message; // Mesajul de răspuns

        // Inițializăm un array pentru căile atașamentelor
        $attachmentPaths = [];

        // Verificăm dacă sunt atașamente
        if ($request->hasFile('attachment')) {
            foreach ($request->file('attachment') as $attachmentFile) {
                // Stocăm fiecare fișier în directorul 'attachments' pe disk-ul public
                $attachmentPath = $attachmentFile->storeAs('attachments', $attachmentFile->getClientOriginalName(), 'public');
                if ($attachmentPath) {
                    $attachmentPaths[] = $attachmentPath; // Adăugăm calea fișierului la array
                }
            }
        }

        try {
            // Trimiterea emailului cu atașamente
            Mail::raw($replyMessage, function ($mail) use ($replyTo, $subject, $account, $attachmentPaths) {
                $mail->to($replyTo)
                    ->from($account)
                    ->subject($subject);

                // Atașăm fiecare fișier
                foreach ($attachmentPaths as $attachmentPath) {
                    $fullAttachmentPath = storage_path('app/public/' . $attachmentPath);
                    $attachmentContent = file_get_contents($fullAttachmentPath);

                    $mail->attachData($attachmentContent, basename($fullAttachmentPath), [
                        'mime' => mime_content_type($fullAttachmentPath),
                    ]);
                }
            });
        } catch (\Exception $e) {
            Log::error('Trimiterea emailului a eșuat: ' . $e->getMessage());
            return response()->json(['error' => 'Trimiterea emailului a eșuat.'], 500);
        }

        // Salvarea emailului trimis în baza de date
        Email::create([
            'user_id'    => $user->id,
            'message_id' => uniqid(),
            'from'       => $account,
            'to'         => $replyTo,
            'subject'    => $subject,
            'body'       => $replyMessage,
            'is_seen'    => false,
            'type'       => 'sent',
            'attachments' => json_encode($attachmentPaths),  // Stocăm căile fișierelor în format JSON
        ]);

        return redirect()->back()->with('success', 'Răspunsul a fost trimis cu succes!');
    }
}
