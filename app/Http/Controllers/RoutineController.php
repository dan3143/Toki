<?php

namespace App\Http\Controllers;

use App\Activity;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class RoutineController extends Controller
{

    const DAYS =["sunday", "monday", "tuesday", "wednesday", "thursday", "friday", "saturday"];
    
    public function index(Request $request, $day, $id=null){
        if (!in_array($day, self::DAYS)){
            abort(404);
        }
        $activities = Activity::where('userId', Auth::id())->where('day', $day)
                                                           ->orderBy('start_hour', 'asc')
                                                           ->get();
        return view('routine', ['activities' => $activities, "day" => $day, 'user' => $id==null?null:User::findOrFail($id)]);
    }

    public function delete($id){
        Activity::findOrFail($id)->delete();
        return $id . " deleted";
    }

    public function store(Request $request, $day){
        $request->validate([
            'input_name' => 'required',
            'input_start_hour' => 'required',
        ]);

        if (isset($request->input_end_hour) && strtotime($request->input_start_hour) > strtotime($request->input_end_hour)){
            $error = \Illuminate\Validation\ValidationException::withMessages([
                'input_end_hour' => ['La hora de fin debe ser mayor a la hora de inicio'],
                'input_start_hour' => ['La hora de inicio debe ser menor a la hora de fin']
            ]);
            throw $error;
        }

        $activity = new Activity;
        $activity->userId = Auth::id();
        $activity->name = $request->input_name;
        $activity->end_hour = $request->input_end_hour;
        $activity->start_hour = $request->input_start_hour;
        $activity->place = $request->input_place;
        $activity->day = $day;
        $activity->save();
        if ($request->repeat){
            foreach (self::DAYS as $day_i){
                if ($request->input($day_i) && $day_i != $day){
                    $activity = new Activity;
                    $activity->userId = Auth::id();
                    $activity->name = $request->input_name;
                    $activity->end_hour = $request->input_end_hour;
                    $activity->start_hour = $request->input_start_hour;
                    $activity->place = $request->input_place;
                    $activity->day = $day_i;
                    $activity->save();
                }
            }
        }
        return redirect()->route('routine', 'monday');
    }

    public function update(Request $request, $day){
        $request->validate([
            'input_name' => 'required',
            'input_start_hour' => 'required',
        ]);

        if (isset($request->input_end_hour) && strtotime($request->input_start_hour) > strtotime($request->input_end_hour)){
            $error = \Illuminate\Validation\ValidationException::withMessages([
                'input_end_hour' => ['La hora de fin debe ser mayor a la hora de inicio'],
                'input_start_hour' => ['La hora de inicio debe ser menor a la hora de fin']
            ]);
            throw $error;
        }

        $activity = Activity::findOrFail($request->id);
        $activity->name = $request->input_name;
        $activity->end_hour = $request->input_end_hour;
        $activity->start_hour = $request->input_start_hour;
        $activity->place = $request->input_place;
        $activity->day = $day;
        $activity->save();
        return redirect()->route('routine', $day);
    }

}
