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
        $message = $inbox->messages();

        if (!$message) {
            return response()->json(['error' => 'Emailul nu a fost găsit.'], 404);
        }
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
}
