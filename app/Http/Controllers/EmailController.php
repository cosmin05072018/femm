<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Webklex\IMAP\Facades\Client;
use Illuminate\Support\Facades\Log;
use App\Models\EmailAccount;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Http;

class EmailController extends Controller
{
    // Metodă pentru a obține și lista emailurile
    // public function fetchEmails($userId)
    public function fetchEmails()
    {
        // $account = EmailAccount::where('user_id', $userId)->first();
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

        dd($messages);

        return view('emails.index', compact('messages'));
    }

    // Metodă pentru a deschide un email specific
    // public function showEmail($userId, $messageId)

    // {
    //     dd($userId, $messageId);
    //     $account = EmailAccount::where('user_id', $userId)->first();

    //     if (!$account) {
    //         return response()->json(['error' => 'Contul de email nu este configurat.'], 404);
    //     }

    //     $client = Client::make([
    //         'host'          => 'mail.domeniultau.ro',
    //         'port'          => 993,
    //         'encryption'    => 'ssl',
    //         'validate_cert' => true,
    //         'username'      => $account->email,
    //         'password'      => Crypt::decryptString($account->password),
    //         'protocol'      => 'imap',
    //     ]);

    //     $client->connect();
    //     $inbox = $client->getFolder('INBOX');
    //     $message = $inbox->messages()->get()->where('uid', $messageId)->first();

    //     if (!$message) {
    //         return response()->json(['error' => 'Emailul nu a fost găsit.'], 404);
    //     }

    //     return view('emails.show', compact('message'));
    // }

    // Metodă pentru a răspunde la un email
    // public function replyEmail(Request $request, $userId, $messageId)
    public function replyEmail(Request $request)
    {
        // $account = EmailAccount::where('user_id', $userId)->first();
        $account = 'contact@femm.ro';
        if (!$account) {
            return response()->json(['error' => 'Contul de email nu este configurat.'], 404);
        }

        $client = Client::make([
            'host'          => 'mail.femm.ro',
            'port'          => 993,
            'encryption'    => 'ssl',
            'validate_cert' => true,
            'username'      => $account,
            // 'password'      => Crypt::decryptString($account->password),
            'password'      => '@mU_(UvcY(ZL',
            'protocol'      => 'imap',
        ]);

        $client->connect();
        $inbox = $client->getFolder('INBOX');
        // $message = $inbox->messages()->get()->where('uid', $messageId)->first();
        $message = $inbox->messages();

        if (!$message) {
            return response()->json(['error' => 'Emailul nu a fost găsit.'], 404);
        }

        // Răspunsul la email
        // Mail::raw($request->input('message'), function ($mail) use ($message, $request) {
        //     // Accesează direct primul expeditor din lista returnată de getFrom()
        //     $recipient = $message->getFrom()[0]->mail;

        //     $mail->to($recipient) // Adresa destinatarului
        //          ->subject('RE: ' . $message->getSubject()) // Subiectul emailului
        //          ->from('cosminmorari99@yahoo.com') // Adresa de email a expeditorului
        //          ->replyTo('cosminmorari99@yahoo.com') // Adresa de reply
        //          ->setBody($request->input('message')); // Conținutul mesajului
        // });
        // Mail::raw('test', function ($mail) {
        //     $mail->to('cosminmorari99@yahoo.com') // Adresa destinatarului
        //          ->subject('Test Email') // Subiectul emailului
        //          ->from('contact@femm.ro', 'Femm Ro') // Adresa de email a expeditorului și numele expeditorului
        //          ->replyTo('cosminmorari99@yahoo.com') // Adresa de reply
        //          ->text('test'); // Conținutul mesajului
        // });
        $fromEmail = "contact@femm.ro";
        $fromName = "Femm Ro";
        Mail::raw('testsssssssss', function ($mail) use ($fromEmail, $fromName) {
            $mail->to('cosminmorari99@yahoo.com')
                ->subject('Test Email')
                ->from('anonimanonimus330@femm.ro', 'mail de test') // Adresa fixă de la Gmail
                ->replyTo($fromEmail, $fromName) // Adresa dinamică
                ->text('testulescuuuuuuuuuuuuu'); // Conținutul mesajului
        });







        return back()->with('success', 'Răspuns trimis cu succes!');
    }

    public function createEmail(Request $request)
    {
        // Validează datele introduse în formular
        $request->validate([
            'email' => 'required|string',
            'password' => 'required|string|min:6',
            'quota' => 'nullable|integer|min:0', // Optional: spațiu alocat în MB
        ]);

        // Construiește URL-ul pentru API-ul cPanel
        $cpanelHost = env('CPANEL_HOST');
        $cpanelUsername = env('CPANEL_USERNAME');
        $cpanelToken = env('CPANEL_API_TOKEN');

        $url = "https://$cpanelHost:2083/execute/Email/add_pop";

        // Parametrii pentru cererea API
        $params = [
            'email' => $request->email,
            'password' => $request->password,
            'quota' => $request->quota ?? 0, // 0 pentru spațiu nelimitat
        ];

        // Efectuează cererea către API cu metoda POST
        $response = Http::withHeaders([
            'Authorization' => "cpanel $cpanelUsername:$cpanelToken",
        ])->post($url, $params);

        // Verifică răspunsul API
        if ($response->successful()) {
            // Afișează răspunsul pentru debugging în caz de succes
            dd('Email creat cu succes:', $response->json());
        } else {
            // Afișează răspunsul pentru debugging în caz de eroare
            dd('Eroare la crearea emailului:', $response->body());
        }
    }
}
