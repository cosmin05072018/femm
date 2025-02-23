<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\EmailSyncController;

class SyncEmailsCommand extends Command
{
    protected $signature = 'emails:sync';
    protected $description = 'Sincronizează emailurile în baza de date';

    public function handle()
    {
        $controller = new EmailSyncController();
        $controller->syncEmails();

        $this->info('Sincronizarea emailurilor a fost realizată cu succes!');
    }
}
