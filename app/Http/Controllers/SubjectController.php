<?php

namespace App\Http\Controllers;

use App\Grade;
use App\Subject;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class SubjectController extends Controller
{

    public function index(Request $request, $id=null)
    {
        return view('subjects', ['subjects' => Subject::where('userId', Auth::id())->get(), 'user' => $id==null?null:User::findOrFail($id)]);
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

    public function delete_grade($subjectId, $id){
        Grade::findOrFail($id)->delete();
        $grades = Grade::where('userId', Auth::id())->where('subjectId', $subjectId);
        return $grades->sum(DB::raw('value * (percentage/100)'));
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
        $info = [
            'subject' => Subject::findOrFail($id),
            'grades'  =>  $grades->get(),
            'defined' => $grades->sum('percentage'),
            'current_grade' => $grades->sum(DB::raw('value * (percentage/100)'))
        ];
        return view('show_subject', $info);
    }

    public function getSum($id){
        $grades = Grade::where('userId', Auth::id())->where('subjectId', $id);
        return  json_encode([
            "sum" => $grades->sum(DB::raw('value * (percentage/100)')),
            "percentage" => $percentage = (1 - $grades->sum('percentage')/100)
        ]);
    }
}
