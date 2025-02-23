<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\EmailSyncController;

class SyncEmailsCommand extends Command
{
    protected $signature = 'emails:sync';
    protected $description = 'Sync emails automatically';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        // Apelează direct metoda din controller
        $controller = new EmailSyncController();
        $controller->syncEmails();

        $this->info('Emails synchronized successfully!');
    }
}
