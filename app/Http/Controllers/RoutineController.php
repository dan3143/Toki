<?php

namespace App\Http\Controllers;

use App\Activity;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class RoutineController extends Controller
{
    public function index(Request $request, $day){
        $days =["sunday", "monday", "tuesday", "wednesday", "thursday", "friday", "saturday"];
        if (!in_array($day, $days)){
            abort(404);
        }
        $activities = Activity::where('userId', Auth::id())->where('day', $day)
                                                           ->orderBy('start_hour', 'asc')
                                                           ->get();
        return view('routine', ['activities' => $activities, "day" => $day]);
    }

    public function delete($id){
        Activity::findOrFail($id)->delete();
        return $id . " deleted";
    }

}
