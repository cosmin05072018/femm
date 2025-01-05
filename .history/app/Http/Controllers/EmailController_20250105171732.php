<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller;

class EmailController extends Controller
{
    public function readEmail()
    {
        // Calea către fișierul rezultat (pipemail.txt)
        $filePath = base_path('public_html/pipemail.txt');

        // Verifică dacă fișierul există
        if (!file_exists($filePath)) {
            dd('Fișierul "pipemail.txt" nu există în public_html.');
        }

        // Citește conținutul fișierului
        $emailContent = file_get_contents($filePath);

        // Afișează conținutul fișierului
        dd($emailContent);
    }
}
