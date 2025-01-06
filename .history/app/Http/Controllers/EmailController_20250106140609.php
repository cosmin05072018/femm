<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Webklex\IMAP\Facades\Client;
use Illuminate\Support\Facades\Log;

<?php

function getCpanelEmailAccounts($cpanelHost, $cpanelUser, $apiToken) {
    $url = "https://{$cpanelHost}:2083/cpanel/execute/Email/list_pops"; // Endpoint pentru emailuri

    $headers = [
        "Authorization: cpanel {$cpanelUser}:{$apiToken}",
    ];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

    $response = curl_exec($ch);
    curl_close($ch);

    $data = json_decode($response, true);

    if (isset($data['status']) && $data['status'] === 1) {
        return $data['data']; // Returnează lista de conturi de email
    }

    throw new Exception("Eroare la preluarea conturilor de email: " . $data['errors'][0] ?? 'Unknown error');
}

try {
    $cpanelHost = "your-cpanel-host.com"; // Domeniul serverului cPanel (ex: mail.femm.ro)
    $cpanelUser = "your-cpanel-username"; // Username-ul cPanel
    $apiToken = "your-api-token"; // Tokenul API generat

    $emailAccounts = getCpanelEmailAccounts($cpanelHost, $cpanelUser, $apiToken);

    foreach ($emailAccounts as $account) {
        echo "Email: {$account['email']}, Quota: {$account['diskquota']} MB\n";
    }
} catch (Exception $e) {
    echo "Eroare: " . $e->getMessage();
}

class EmailController extends Controller
{
    public function getEmails()
    {
        // Conectează-te la contul IMAP
        $client = Client::account('default');
        $client->connect();

        // Obține inbox-ul
        $inbox = $client->getFolder('INBOX');

        // Obține toate mesajele
        $messages = $inbox->messages()->all()->get();

        $emails = []; // Asigură-te că array-ul este inițializat

        foreach ($messages as $index => $message) {


            // Ignoră mesajul de la indexul 0 (primul mesaj din listă)
            if ($index == 0) {
                continue;
            }

            $subject = $message->getSubject();
            $messageBody = strip_tags($message->getTextBody());  // elimină etichetele HTML

            // Preia expeditorul
            $from = $message->header->from[0]->mail;  // returnează un array asociativ

            // Obține doar adresa de e-mail a expeditorului

            // Sau, în caz că există mai mulți expeditori, se poate folosi:
            // $fromEmail = array_key_first($from);

            // Verifică dacă există conținut în mesaj
            if (empty($subject) && empty($messageBody)) {
                continue;  // Sar peste mesajele goale
            }

            // Poți adăuga o filtrare suplimentară pentru a curăța conținutul
            $messageBody = preg_replace('/(Server.*?Port.*?=\s*\d+|.*?SSL.*?Settings.*?)/s', '', $messageBody);

            // Adaugă datele în array doar pentru mesajele valabile
            $emails[] = [
                'subject' => $subject,
                'body' => $messageBody,
                'from_email' => $from,  // Aici avem doar adresa de e-mail a expeditorului
            ];
        }

        // Trimite datele către view
        return view('mailuri', ['emails' => $emails]);
    }
}
