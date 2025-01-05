<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller;

class EmailController extends Controller
{
    public function readEmail()
    {
        // Path to the pipescript.php
        $pipescriptPath = base_path('public_html/pipescript.php'); // folosim calea absolută

        // Execute the pipescript and capture its output
        $output = '';
        $handle = popen('php ' . escapeshellarg($pipescriptPath), 'r');
        if ($handle) {
            while (!feof($handle)) {
                $output .= fread($handle, 8192);
            }
            pclose($handle);
        }

        // Use dd() to display the output
        dd($output);
    }
}
