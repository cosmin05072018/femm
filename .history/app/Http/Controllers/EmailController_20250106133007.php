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

        $emails = []; // Asigură-te că array-ul este inițializat

        foreach ($messages as $index => $message) {


            // Ignoră mesajul de la indexul 0 (primul mesaj din listă)
            if ($index == 0) {
                continue;
            }
            echo '<pre>';
            dd($index, $messages['config']);
            echo '</pre>';

            $subject = $message->getSubject();
            $messageBody = strip_tags($message->getTextBody());  // elimină etichetele HTML

            // Preia expeditorul
            $from = $message->getFrom();  // returnează un array asociativ

            // Obține doar adresa de e-mail a expeditorului
            $fromEmail = key($from); // adresa de e-mail (cheia din array-ul asociativ)
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
                'from_email' => $fromEmail,  // Aici avem doar adresa de e-mail a expeditorului
            ];
        }

        // Trimite datele către view
        return view('mailuri', ['emails' => $emails]);
    }
}
