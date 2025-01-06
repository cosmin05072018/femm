<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Webklex\IMAP\Facades\Client;
use Illuminate\Support\Facades\Log;

class EmailController extends Controller
{
    public function readEmail(Request $request)
    {
        // Conectează-te la serverul IMAP
        $client = Client::account('default');
        $client->connect();

        // Obține inbox-ul
        $inbox = $client->getFolder('INBOX');
        $messages = $inbox->messages()->all()->get();

        foreach ($messages as $message) {
            echo 'Subiect: ' . $message->getSubject() . '<br>';
            $messageBody = strip_tags($message->getTextBody());
            echo 'Mesaj: ' . nl2br($messageBody) . '<br>';
        }
    }
}
