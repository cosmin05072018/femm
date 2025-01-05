<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller;

class EmailController extends Controller
{
    public function readEmail(Request $request)
    {

        return $request->all();
    }
}
