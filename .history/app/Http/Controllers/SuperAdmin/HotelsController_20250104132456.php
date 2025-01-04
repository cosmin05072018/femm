<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Hotel;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class HotelsController extends Controller
{
    public function index()
    {
        $owner = User::where('role', 'owner')->first();
        $hotels = Hotel::all();

        return view('superAdmin/hotels', compact('owner', 'hotels'));
    }

    public function show(Request $request){
        $hotel = Hotel::where('id', $request->id)->first();
        $users = User::where('hotel_id', $request->id)->get();

        $data = [$hotel, $users];
        return view('superAdmin/hotel')->with('data' => [$users, $hotel]);
    }
}
