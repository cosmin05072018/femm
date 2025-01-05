<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller;

class EmailController extends Controller
{
    public function readEmail()
    {
        // Path to the pipescript.php
        $pipescriptPath = base_path('pipescript.php');

        // Execute the pipescript and capture its output
        $output = '';
        $handle = fopen('php ' . escapeshellarg($pipescriptPath), 'r');
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
