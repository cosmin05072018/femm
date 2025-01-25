<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Webklex\IMAP\Facades\Client;
use Illuminate\Support\Facades\Log;
use App\Models\EmailAccount;
use Illuminate\Support\Facades\Crypt;
class EmailController extends Controller
{
    // Metodă pentru a obține și lista emailurile
    // public function fetchEmails($userId)
    public function fetchEmails()
    {
        // $account = EmailAccount::where('user_id', $userId)->first();
        $account= 'contact@femm.ro';
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
            'password'      => '@mU_(UvcY(ZL',
            'protocol'      => 'imap',
        ]);

        $client->connect();
        $inbox = $client->getFolder('INBOX');
        $messages = $inbox->messages()->all()->get();

        return view('emails.index', compact('messages'));
    }

    // Metodă pentru a deschide un email specific
    public function showEmail($userId, $messageId)
    {
        dd($userId, $messageId);
        $account = EmailAccount::where('user_id', $userId)->first();

        if (!$account) {
            return response()->json(['error' => 'Contul de email nu este configurat.'], 404);
        }

        $client = Client::make([
            'host'          => 'mail.domeniultau.ro',
            'port'          => 993,
            'encryption'    => 'ssl',
            'validate_cert' => true,
            'username'      => $account->email,
            'password'      => Crypt::decryptString($account->password),
            'protocol'      => 'imap',
        ]);

        $client->connect();
        $inbox = $client->getFolder('INBOX');
        $message = $inbox->messages()->get()->where('uid', $messageId)->first();

        if (!$message) {
            return response()->json(['error' => 'Emailul nu a fost găsit.'], 404);
        }

        return view('emails.show', compact('message'));
    }

    // Metodă pentru a răspunde la un email
    public function replyEmail(Request $request, $userId, $messageId)
    {
        dd($request, $userId, $messageId);
;        $request->validate([
            'message' => 'required',
        ]);

        $account = EmailAccount::where('user_id', $userId)->first();

        if (!$account) {
            return response()->json(['error' => 'Contul de email nu este configurat.'], 404);
        }

        $client = Client::make([
            'host'          => 'mail.domeniultau.ro',
            'port'          => 993,
            'encryption'    => 'ssl',
            'validate_cert' => true,
            'username'      => $account->email,
            'password'      => Crypt::decryptString($account->password),
            'protocol'      => 'imap',
        ]);

        $client->connect();
        $inbox = $client->getFolder('INBOX');
        $message = $inbox->messages()->get()->where('uid', $messageId)->first();

        if (!$message) {
            return response()->json(['error' => 'Emailul nu a fost găsit.'], 404);
        }

        \Mail::raw($request->message, function ($mail) use ($message, $account, $request) {
            $mail->to($message->getFrom()[0]->mail)
                 ->subject('RE: ' . $message->getSubject())
                 ->from($account->email)
                 ->replyTo($account->email)
                 ->setBody($request->message);
        });

        return back()->with('success', 'Răspuns trimis cu succes!');
    }
}
