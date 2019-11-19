<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Deadline;
use App\Subject;
use App\User;

class DeadlineController extends Controller
{
    private $deadlines;

    public function index(Request $request, $id=null){
        return view('deadlines', [
                'deadlines' => Deadline::where('userId', Auth::id())
                    ->orderBy('end_date', 'asc')
                    ->orderBy('priority', 'desc')
                    ->get(), 
                'id' => Auth::id(),
                'user' => $id==null?null:User::findOrFail($id)
             ]);
    }

    public function create(Request $request){
        return view('create_deadline', ["subjects" => Subject::where('userId', Auth::id())->get()]);
    }

    public function store(Request $request){
        $request->validate([
            'input_deadline_name' => 'required',
            'input_date' => 'required',
            'input_time' => 'required',
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
    }

    public function delete($id){
        Deadline::findOrFail($id)->delete();
        return $id . " deleted";
    }

    public function edit($id){
        $deadline = Deadline::findOrFail($id);
        return view('edit_deadline', ['deadline' => $deadline, "subjects" => Subject::where('userId', Auth::id())->get()]);
    }

    public function update(Request $request, $id){
        $deadline = Deadline::findOrFail($id);
        $request->validate([
            'input_deadline_name' => 'required',
            'input_date' => 'required',
            'input_time' => 'required',
        ]);
        $deadline->name = $request->input_deadline_name;
        $deadline->end_date = $request->input_date;
        $deadline->end_hour = $request->input_time;
        $deadline->subjectId = $request->input_subject;
        $deadline->priority = $request->input_priority;
        $deadline->save();
        return redirect()->route('deadlines');
    }

    

}
