<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Deadline;
use App\Subject;

class DeadlineController extends Controller
{
    private $deadlines;

    public function index(Request $request){
        return view('deadlines', ['deadlines' => Deadline::where('userId', Auth::id())->get(), 'id'=>Auth::id()]);
    }

    public function create(Request $request){
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

    public function delete($id){
        Deadline::where('id', $id)->delete();
        return redirect()->route('deadlines');
    }
    

}
