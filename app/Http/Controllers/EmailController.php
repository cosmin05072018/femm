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
    // Obține emailurile pentru utilizatorul conectat
    public function fetchEmails()
    // public function fetchEmails($userId)
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
            // 'username'      => $account->email,
            'username'      => $account,
            // 'password'      => Crypt::decryptString($account->password),
            'password'      => 'S+g)d1GKv7Ky',
            'protocol'      => 'imap',
        ]);

        $client->connect();
        $inbox = $client->getFolder('INBOX');
        $messages = $inbox->messages()->all()->get();

        return view('emails.index', compact('messages'));
    }

    // Trimite un email
    // public function sendEmail(Request $request)
    // {
    //     $request->validate([
    //         'to' => 'required|email',
    //         'subject' => 'required',
    //         'message' => 'required',
    //     ]);

    //     $userId = auth()->id();
    //     $account = EmailAccount::where('user_id', $userId)->first();

    //     if (!$account) {
    //         return response()->json(['error' => 'Contul de email nu este configurat.'], 404);
    //     }

    //     config([
    //         'mail.mailers.smtp.host' => 'mail.domeniultau.ro',
    //         'mail.mailers.smtp.port' => 465,
    //         'mail.mailers.smtp.encryption' => 'ssl',
    //         'mail.mailers.smtp.username' => $account->email,
    //         'mail.mailers.smtp.password' => Crypt::decryptString($account->password),
    //     ]);

    //     \Mail::raw($request->message, function ($message) use ($request, $account) {
    //         $message->to($request->to)
    //                 ->subject($request->subject)
    //                 ->from($account->email);
    //     });

    //     return back()->with('success', 'Email trimis cu succes!');
    // }
}
