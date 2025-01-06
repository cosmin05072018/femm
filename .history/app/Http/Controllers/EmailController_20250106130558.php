<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Webklex\IMAP\Facades\Client;
use Illuminate\Support\Facades\Log;

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

        $emails = [];  // Array pentru a stoca datele emailurilor
        dd( $messages);
        foreach ($messages as $message) {
            // Preia subiectul și corpul mesajului
            $subject = $message->getSubject();
            $messageBody = strip_tags($message->getTextBody());  // elimină etichetele HTML

            // Poți adăuga o filtrare suplimentară pentru a curăța conținutul
            $messageBody = preg_replace('/(Server.*?Port.*?=\s*\d+|.*?SSL.*?Settings.*?)/s', '', $messageBody);

            // Adaugă datele în array
            $emails[] = [
                'subject' => $subject,
                'body' => $messageBody,
            ];
        }

        // Trimite datele către view
        return view('mailuri', ['emails' => $emails]);
    }
}
