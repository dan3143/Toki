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

    public function store(Request $request, $day){
        $request->validate([
            'input_name' => 'required',
            'input_start_hour' => 'required',
            'input_end_hour' => 'required',
        ]);
        $activity = new Activity;
        $activity->userId = Auth::id();
        $activity->name = $request->input_name;
        $activity->end_hour = $request->input_end_hour;
        $activity->start_hour = $request->input_start_hour;
        $activity->place = $request->input_place;
        $activity->day = $day;
        $activity->save();
        return redirect()->route('routine', $day);
    }

}
