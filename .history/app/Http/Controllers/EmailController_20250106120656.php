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
            Log::info('Starting email read process...');

            // Conectează-te la contul IMAP
            $client = Client::account('default');
            $client->connect();

            // Verifică conexiunea
            if (!$client->isConnected()) {
                Log::warning('Failed to connect to IMAP server.');
                return response()->json(['error' => 'Failed to connect to IMAP server.'], 500);
            }

            Log::info('Successfully connected to IMAP server.');

            // Obține folderul INBOX
            $folder = $client->getFolder('INBOX');
            Log::info('Fetched folder INBOX.');

            $messages = $folder->query()->get();
            Log::info('Number of messages retrieved: ' . count($messages));

            $emails = [];

            foreach ($messages as $message) {
                Log::info('Processing message with subject: ' . ($message->getSubject() ?? 'No subject'));

                $from = $message->getFrom();
                Log::info('From field: ', $from);

                // Asigură-te că `getFrom()` este procesat corect
                $from_email = 'Unknown';
                if (is_array($from) && isset($from[0])) {
                    $from_email = isset($from[0]->mail) ? $from[0]->mail : 'Unknown';
                }

                $emails[] = [
                    'subject' => $message->getSubject() ?? 'No subject',
                    'from'    => $from_email,
                    'body'    => $message->getTextBody() ?? 'No body',
                    'date'    => $message->getDate() ? $message->getDate()->toDateTimeString() : 'Unknown date',
                ];

                // Marchează mesajul ca citit
                $message->setFlag('Seen');
            }

            return response()->json($emails);
        } catch (\Exception $e) {
            Log::error('Error reading emails: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
