<?php

namespace App\Http\Controllers;

use App\user_room;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
class UserRoomController extends Controller
{

    public function index(Request $request){
        $usroom = DB::table('user_rooms')->get();
        return view('user_rooms', ['useroom' => $usroom]);
    }
}