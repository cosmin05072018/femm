<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Email;
use Illuminate\Support\Facades\Storage;
use Exception;
use Webklex\IMAP\Facades\Client;
use Illuminate\Support\Facades\Mail;
use Webklex\PHPIMAP\ClientManager;
use Illuminate\Support\Facades\Log;


class EmailSyncController extends Controller
{
    public function syncEmails()
    {
        $users = User::whereNotNull('email_femm')->whereNotNull('password_mail_femm')->get();

        foreach ($users as $user) {
            try {
                // Conectare la IMAP
                $client = Client::make([
                    'host'          => 'mail.femm.ro',
                    'port'          => 993,
                    'encryption'    => 'ssl',
                    'validate_cert' => true,
                    'username'      => $user->email_femm,
                    'password'      => $user->password_mail_femm,
                    'protocol'      => 'imap',
                ]);

                $client->connect();
                $inbox = $client->getFolder('INBOX');
                $messages = $inbox->query()->all()->get();

                foreach ($messages as $message) {
                    $messageId = $message->getMessageId();

                    // Verificăm dacă emailul există deja în baza de date
                    if (!Email::where('message_id', $messageId)->exists()) {
                        $attachmentsData = [];

                        // Descărcăm atașamentele
                        foreach ($message->getAttachments() as $attachment) {
                            $filename = time() . '-' . $attachment->getName();
                            $path = "emails/attachments/{$user->id}/" . $filename;

                            // Salvăm atașamentul pe server
                            Storage::disk('public')->put($path, $attachment->getContent());

                            // Adăugăm calea în array
                            $attachmentsData[] = $path;
                        }

                        $toAddresses = $message->getTo();
                        $toEmails = [];

                        if (is_array($toAddresses) || $toAddresses instanceof \Traversable) {

                            foreach ($toAddresses as $to) {
                                $toEmails[] = $to->mail;
                            }
                        }

                        // Salvăm emailul în baza de date
                        Email::create([
                            'user_id'    => $user->id,
                            'message_id' => $messageId,
                            'from'       => $message->getFrom()[0]->mail ?? 'Unknown',
                            'to' => implode(',', $toEmails),
                            'subject'    => $message->getSubject() ?? 'No Subject',
                            'body'       => $message->getTextBody() ?? 'No Content',
                            'is_seen'    => $message->getFlags()->contains('Seen'),
                            'attachments' => json_encode($attachmentsData),
                        ]);
                    }
                }
            } catch (Exception $e) {
                Log::error("Eroare la sincronizarea emailurilor pentru utilizatorul {$user->id}: " . $e->getMessage());
            }
        }

        return response()->json(['message' => 'Sincronizare finalizată.']);
    }
}
