<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;

class EmailController extends Controller
{
    public function readEmail(Request $request)
    {

        $email = $request->all()['email'];

    }
}
