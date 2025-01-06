<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
class EmailController extends Controller {
    public function getFromReceiver(Request $request) {
       Log::info($request->all());
    }
}
