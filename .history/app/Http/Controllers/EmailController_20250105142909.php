<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\IMAP;

class EmailController extends Controller
{
    public function readEmail()
    {
        $user = Auth::user(); // Obținem utilizatorul logat

        if ($user) {
            // Fetch emails from user's mailbox
            $emails = IMAP::get($user->email, 'INBOX', 'UNSEEN', $user->email, $user->password); // Prinde emailuri necitite
            return response()->json($emails);
        } else {
            return response()->json(['error' => 'User not authenticated'], 401);
        }
    }
}
