<?php

namespace App\Http\Controllers;

use App\UserRoom;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
class UserRoomController extends Controller
{

    public function index(Request $request){
        return view('user_rooms', ['useroom' => UserRoom::all()]);
    }
}