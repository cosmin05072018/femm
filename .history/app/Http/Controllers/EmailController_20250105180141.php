<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller;

class EmailController extends Controller
{
    public function readEmail()
    {
        // Path to the pipescript.php
        $pipescriptPath = base_path('public_html/pipescript.php');

        // Execute the pipescript and capture its output
        $output = [];
        $descriptorSpec = [
            1 => ['pipe', 'w'], // stdout is a pipe that the child process writes to
        ];
        $process = proc_open('php ' . escapeshellarg($pipescriptPath), $descriptorSpec, $pipes);

        if (is_resource($process)) {
            while (!feof($pipes[1])) {
                $output[] = fread($pipes[1], 8192);
            }
            fclose($pipes[1]);
            proc_close($process);
        }

        // Use dd() to display the output
        dd(implode("\n", $output));
    }
}
