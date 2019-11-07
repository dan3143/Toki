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

    public function store(Request $request){
        $room = new UserRoom;
        $room->name = $request->input_name;
        $room->location = $request->input_place;
        $room->is_available = true;
        $room->max_capacity = 0;
        $room->current_capacity = 0;
        $room->save();
        return redirect()->route('user_room');
    }

    public function change_status($id){
        $room = UserRoom::findOrFail($id);
        $room->is_available = !$room->is_available;
        $room->save();
        return redirect()->route('user_room');
    }

    public function delete($id){
        UserRoom::findOrFail($id)->delete();
        return $id . " deleted";
    }

    public function update(Request $request){
        $request->validate([
            'input_name' => 'required',
            'input_place' => 'required',
        ]);
        $room = UserRoom::findOrFail($request->id);
        $room->name = $request->input_name;
        $room->location = $request->input_place;
        $room->save();
        return redirect()->route('user_room');
    }

}