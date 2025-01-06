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

            // Conectarea la serverul IMAP
            $client = Client::account('default'); // Conexiunea IMAP definită în `imap.php`
            $client->connect();
            Log::info('Successfully connected to IMAP server.');

            // Obține folderul INBOX
            $folder = $client->getFolder('INBOX');
            Log::info('Fetched folder INBOX.');

            // Obține mesajele din INBOX
            $messages = $folder->query()->get();
            Log::info('Fetched messages from INBOX.');

            $emails = [];

            foreach ($messages as $message) {
                // Preia detaliile expeditorului
                $from = $message->getFrom();

                // Adaugă informațiile fiecărui mesaj într-un array
                $emails[] = [
                    'subject' => $message->getSubject() ?? 'No subject',
                    'from'    => isset($from[0]) && isset($from[0]->mail) ? $from[0]->mail : 'Unknown',
                    'body'    => $message->getTextBody() ?? 'No body',
                    'date'    => $message->getDate() ? $message->getDate()->toDateTimeString() : 'Unknown date',
                ];

                // Log pentru mesajul procesat
                Log::info('Processing message:', [
                    'subject' => $emails[count($emails) - 1]['subject'],
                    'from'    => $emails[count($emails) - 1]['from'],
                    'date'    => $emails[count($emails) - 1]['date'],
                ]);

                // Marchează mesajul ca citit
                $message->setFlag('Seen');
            }

            // Returnează mesajele ca răspuns JSON
            return response()->json($emails);
        } catch (\Exception $e) {
            // Log în cazul unei erori
            Log::error('Error reading emails: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
