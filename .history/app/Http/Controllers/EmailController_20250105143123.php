<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\IMAP;
use Illuminate\Routing\Controller;

class EmailController extends Controller
{
    public function readEmail()
    {
        // $user = Auth::user();

        // if ($user) {
        //     $emails = IMAP::get($user->email, 'INBOX', 'UNSEEN', $user->email, $user->password);
        //     return response()->json($emails);
        // } else {
        //     return response()->json(['error' => 'User not authenticated'], 401);
        // }
    }
}
