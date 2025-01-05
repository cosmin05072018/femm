<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller;

class EmailController extends Controller
{
    public function readEmail()
    {
        // Calea către fișierul generat de scriptul "pipescript.php"
        $filePath = base_path('public_html/pipemail.txt'); // Folosește base_path pentru a indica locația corectă

        // Verifică dacă fișierul există
        if (!file_exists($filePath)) {
            // Returnează un mesaj dacă fișierul nu există
            dd('Fișierul "pipemail.txt" nu există în public_html.');
        }

        // Citește conținutul fișierului
        $emailContent = file_get_contents($filePath);

        // Afișează conținutul fișierului folosind dd()
        dd($emailContent);
    }
}
