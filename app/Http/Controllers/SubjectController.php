<?php

namespace App\Http\Controllers;

use App\Grade;
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

    public function addGrade(Request $request, $id){
        $request->validate([
            'input_value' => 'required',
            'input_percentage' => 'required'
        ]);
        $grade = new Grade;
        $grade->userId = Auth::id();
        $grade->subjectId = $id;
        $grade->value = $request->input_value;
        $grade->percentage = $request->input_percentage;
        $grade->save();
        return redirect()->route('subjects.show', $id);
    }

    public function delete_grade($id){
        Grade::findOrFail($id)->delete();
        return $id . " deleted";
    }

    public function delete($id){
        Subject::findOrFail($id)->delete();
        return $id . " deleted";
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

    public function show($id){
        $grades = Grade::where('userId', Auth::id())->where('subjectId', $id);
        return view('show_subject', [
            'subject' => Subject::findOrFail($id),
            'grades'  =>  $grades->get(),
            'defined' => $grades->sum('percentage'),
        ]);
    }

    

}
