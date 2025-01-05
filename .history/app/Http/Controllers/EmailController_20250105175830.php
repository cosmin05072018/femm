<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controller;

class EmailController extends Controller
{
    public function readEmail()
    {
        // Path to the pipescript.php
        $pipescriptPath = base_path('public_html/pipescript.php');

        // Execute the pipescript and capture its output
        $output = shell_exec('php ' . escapeshellarg($pipescriptPath) . ' < /dev/null');

        // Use dd() to display the output
        dd($output);
    }
}
