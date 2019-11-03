<?php

namespace App\Http\Controllers;

use App\Subject;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    public function index(Request $request){
        return view('subjects', ['subjects' => Subject::where('userId', Auth::id())->get()]);
    }

    public function create(){
        return view('create_subject');
    }

    public function store(Request $request){
        $request->validate([
            'input_subject_name' => 'required',
        ]);
        $subject = new Subject;
        $subject->userId = Auth::id();
        $subject->name = $request->input_subject_name;
        $subject->teacherName = $request->input_teacher_name;
        $subject->absenceMax = $request->input_max_absences;
        $subject->status = "studying";
        $subject->save();
        return redirect()->route('subjects');
    }

    public function delete($id){
        Subject::findOrFail($id)->delete();
        return redirect()->route('subjects');
    }

    public function edit($id){
        $subject = Subject::findOrFail($id);
        return view('edit_subject', ['subject' => $subject]);
    }

    public function update(Request $request, $id){
        
        $subject = Subject::findOrFail($id);
        $request->validate([
            'input_subject_name' => 'required',
            'input_status' => 'required',
        ]);
        $subject->name = $request->input_subject_name;
        $subject->teacherName = $request->input_teacher_name;
        $subject->absenceMax = $request->input_max_absences;
        $subject->status = $request->input_status;
        $subject->save();
        return redirect()->route('subjects');
    }

    public function increment($id){
        $subject = Subject::findOrFail($id);
        $subject->absenceNumber++;
        $subject->save();
        return $id . " incremented";
    }

    public function decrement($id){
        $subject = Subject::findOrFail($id);
        $subject->absenceNumber--;
        $subject->save();
        return $id . " decremented";
    }

}
