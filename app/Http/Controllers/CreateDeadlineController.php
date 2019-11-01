<?php

namespace App\Http\Controllers;

use App\Deadline;
use App\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class CreateDeadlineController extends Controller
{
    public function index(Request $request){
        return view('create_deadline', ["subjects" => Subject::where('userId', Auth::id())->get()]);
    }

    public function store(Request $request){
        $validatedData = $request->validate([
            'input_deadline_name' => 'required',
            'input_date' => 'required',
            'input_time' => 'required',
            'input_subject' => 'required',
            'input_priority' => 'required',
        ]);
        $deadline = new Deadline;
        $deadline->userId = Auth::id();
        $deadline->name = $request->input_deadline_name;
        $deadline->end_date = $request->input_date;
        $deadline->end_hour = $request->input_time;
        $deadline->subjectId = $request->input_subject;
        $deadline->priority = $request->input_priority;
        $deadline->save();
        return redirect()->route('deadlines');
        //return $request;
    }

}
