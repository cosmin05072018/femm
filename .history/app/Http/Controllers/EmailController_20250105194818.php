<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;

class EmailController extends Controller
{
    public function readEmail(Request $request)
    {

        return $request->all()['email'];
    }
}
