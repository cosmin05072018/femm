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
            echo $message->getSubject() . '<br>';
            echo $message->getDate()->format('Y-m-d H:i:s') . '<br>';
            echo $message->getTextBody() . '<br>';
        }
    }
}
