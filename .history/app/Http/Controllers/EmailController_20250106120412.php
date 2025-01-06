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

            // Obține clientul IMAP
            $client = Client::account('default'); // Conexiunea IMAP definită în `imap.php`
            $client->connect();

            // Verifică dacă clientul este conectat
            if ($client->isConnected()) {
                Log::info('Successfully connected to IMAP server.');
            } else {
                Log::warning('Failed to connect to IMAP server.');
                return response()->json(['error' => 'Failed to connect to IMAP server.'], 500);
            }

            // Obține folderul INBOX
            $folder = $client->getFolder('INBOX');
            $messages = $folder->query()->get();

            $emails = [];
            foreach ($messages as $message) {
                // Extrage detalii despre expeditor
                $from = $message->getFrom();
                $from_email = isset($from[0]) && isset($from[0]->mail) ? $from[0]->mail : 'Unknown';

                // Construiește detaliile fiecărui email
                $emails[] = [
                    'subject' => $message->getSubject() ?? 'No subject',
                    'from'    => $from_email,
                    'body'    => $message->getTextBody() ?? 'No body',
                    'date'    => $message->getDate() ? $message->getDate()->toDateTimeString() : 'Unknown date',
                ];

                // Marchează ca citit
                $message->setFlag('Seen');
            }

            // Returnează răspunsul JSON
            return response()->json($emails);
        } catch (\Exception $e) {
            // Loghează eroarea
            Log::error('Error reading emails: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
