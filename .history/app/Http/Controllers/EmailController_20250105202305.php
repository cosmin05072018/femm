<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller;

class EmailController extends Controller
{
    public function readEmail()
    {

        return response()->json([
            'test' => '1'
        ]);
    }
}
