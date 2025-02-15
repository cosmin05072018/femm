<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Webklex\IMAP\Facades\Client;
use App\Models\Email;
use App\Models\User;


class SyncEmailsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function handle()
    {
        $client = Client::make([
            'host'          => 'mail.femm.ro',
            'port'          => 993,
            'encryption'    => 'ssl',
            'validate_cert' => true,
            'username'      => $this->user->email_femm,
            'password'      => $this->user->password_mail_femm,
            'protocol'      => 'imap',
        ]);

        $client->connect();
        $inbox = $client->getFolder('INBOX');

        foreach ($inbox->messages()->all()->get() as $message) {
            Email::updateOrCreate(
                ['email_id' => $message->getMessageId()], // Asigurăm unicitatea
                [
                    'user_id' => $this->user->id,
                    'from'    => $message->getFrom()[0]->mail,
                    'to'      => $message->getTo()[0]->mail ?? '',
                    'subject' => $message->getSubject(),
                    'body'    => $message->getTextBody(),
                    'date'    => $message->getDate(),
                    'is_read' => $message->getFlags()->has('seen'),
                ]
            );
        }
    }
}
