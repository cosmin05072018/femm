<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Webklex\IMAP\Facades\Client;

class EmailController extends Controller
{
    public function readEmail(Request $request)
    {

       // $email = $request->all()['email'];

        $client = Client::account('default'); // The name from `imap.php`
        $client->connect();

        // Get the inbox folder
        $folder = $client->getFolder('INBOX');

        // Fetch all unseen (new) emails
        $messages = $folder->query()->unseen()->get();

        $emails = [];
        foreach ($messages as $message) {
            $emails[] = [
                'subject' => $message->getSubject(),
                'from'    => $message->getFrom()[0]->mail,
                'body'    => $message->getTextBody(),
                'date'    => $message->getDate(),
            ];

            // Optionally mark as read
            $message->setFlag('Seen');
        }

        return response()->json($emails); // Return as JSON
    }
}
