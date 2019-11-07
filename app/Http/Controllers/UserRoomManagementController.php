<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Computer;
use App\UserRoom;

class UserRoomManagementController extends Controller
{
    public function index(Request $request, $id){
        return view('user_room_management', 
            ['pcs' => Computer::where('useroomid', $id)
                              ->orderBy('id', 'asc')
                              ->get(),
            'id' => $id]);
    }


    public function addComputer($id){
        $pc = new Computer;
        $pc->useroomid = $id;
        $pc->is_available = true;
        $pc->save();
        $userRoom = UserRoom::findOrFail($id);
        $userRoom->max_capacity++;
        $userRoom->current_capacity = $userRoom->max_capacity;
        $userRoom->save();
        return $pc->id;
    }

    public function deleteComputer($pc_id){
        Computer::findOrFail($pc_id)->delete();
        return $pc_id;
    }

    public function change_status($id){
        $pc = Computer::findOrFail($id);
        $pc->is_available = !$pc->is_available;
        $pc->save();
        $room = UserRoom::findOrFail($pc->useroomid);
        if ($pc->is_available == 1){
            $room->current_capacity++;
        }else{
            $room->current_capacity--;
        }
        $room->save();
        return $pc->is_available ? "1":"0";
    }
}
