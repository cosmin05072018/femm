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
        try {
            $client = Client::account('default'); // Conexiunea IMAP definită în `imap.php`
            $client->connect();

            // Accesează folderul INBOX
            $folder = $client->getFolder('INBOX');

            // Obține toate email-urile necitite
            $messages = $folder->query()->get();

            $emails = [];
            foreach ($messages as $message) {
                $from = $message->getFrom();
                $emails[] = [
                    'subject' => $message->getSubject() ?? 'No subject',
                    'from'    => isset($from[0]) && isset($from[0]->mail) ? $from[0]->mail : 'Unknown',
                    'body'    => $message->getTextBody() ?? 'No body',
                    'date'    => $message->getDate() ? $message->getDate()->toDateTimeString() : 'Unknown date',
                ];

                // Marchează ca citit
                $message->setFlag('Seen');
            }

            return response()->json($emails); // Returnează email-urile ca JSON
        } catch (\Exception $e) {
            Log::error('Error reading emails: ' . $e->getMessage());
            return response()->json(['error' => 'Could not read emails'], 500);
        }
    }
}
