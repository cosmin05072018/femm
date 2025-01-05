<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class EmailController extends Controller
{
    public function readEmail(Request $request)
    {
        // Validate incoming request
        $request->validate([
            'headers' => 'required|array',
            'body' => 'required|string',
        ]);

        // Debugging: Display data using dd()
        dd('Received Data:', $request->all());

        // Optional: Save to database or process further
        // Example saving to a table named 'emails':
        // Email::create([
        //     'headers' => json_encode($request->headers),
        //     'body' => $request->body,
        // ]);

        // Return a response
        return response()->json(['message' => 'Email received successfully.']);
    }
}
