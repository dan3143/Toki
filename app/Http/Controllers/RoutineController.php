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
        $activity = Activity::findOrFail($id);
        if ($activity->userId === Auth::id()){
            $activity->delete();
            return $id . " deleted";
        }
        abort(403, "You cannot delete someone else's activity");
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
        $activity = Activity::findOrFail($request->id);
        if ($activity->userId === Auth::id()){
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
    
            
            $activity->name = $request->input_name;
            $activity->end_hour = $request->input_end_hour;
            $activity->start_hour = $request->input_start_hour;
            $activity->place = $request->input_place;
            $activity->day = $day;
            $activity->save();
            return redirect()->route('routine', $day);
        }
        abort(403, "You cannot update someone else's activity");
    }

    public function import($id){
        $activity = Activity::findOrFail($id);
        if (!$activity->isPrivate){
            $imported = new Activity;
            $imported->userId = Auth::id();
            $imported->name = $activity->name;
            $imported->end_hour = $activity->end_hour;
            $imported->start_hour = $activity->start_hour;
            $imported->place = $activity->place;
            $imported->day = $activity->day;
            $imported->save();
            return $id . " imported";
        }
        abort(403, "You cannot import private activities");
    }

}
