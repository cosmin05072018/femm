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

            $folder = $client->getFolder('INBOX');
            $messages = $folder->query()->unseen()->get();

            $emails = [];
            foreach ($messages as $message) {
                Log::info('Processing message: ', [
                    'subject' => $message->getSubject(),
                    'from'    => $message->getFrom(),
                    'date'    => $message->getDate(),
                ]);

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

            return response()->json($emails);
        } catch (\Exception $e) {
            Log::error('Error reading emails: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }

    }
}
