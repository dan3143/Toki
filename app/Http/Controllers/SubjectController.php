<?php

namespace App\Http\Controllers;

use App\Grade;
use App\Subject;
use App\User;
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
        $subject->isPrivate = $request->has('check_private') ? 1 : 0;
        $subject->status = "studying";
        $subject->save();
        return redirect()->route('subjects');
    }

    public function addGrade(Request $request, $id){
        $request->validate([
            'input_value' => 'required',
            'input_percentage' => 'required'
        ]);
        $subject = Subject::findOrFail($id);
        if($subject->userId === Auth::id()){
            $grade = new Grade;
            $grade->userId = Auth::id();
            $grade->subjectId = $id;
            $grade->value = $request->input_value;
            $grade->percentage = $request->input_percentage;
            $grade->save();
            return redirect()->route('subjects.show', $id);
        }
        abort(403, "You cannot add grades to someone else's subject");
    }

    public function delete_grade($subjectId, $id){
        $grade = Grade::findOrFail($id);
        if ($grade->userId === Auth::id()){
            $grade->delete();
            $grades = Grade::where('userId', Auth::id())->where('subjectId', $subjectId);
            return $grades->sum(DB::raw('value * (percentage/100)'));
        }
        abort(403, "You cannot delete someone else's grade");
    }

    public function delete($id){
        $subject = Subject::findOrFail($id);
        if ($subject->userId === Auth::id()){
            $subject->delete();
            return $id . " deleted";
        }
        abort(403, "You cannot delete someone else's subject");
    }

    public function edit($id){
        $subject = Subject::findOrFail($id);
        if ($subject->userId === Auth::id()){
            return view('edit_subject', ['subject' => $subject]);
        }
        abort(403, "You cannot edit someone else's subject");
    }

    public function update(Request $request, $id){
        $subject = Subject::findOrFail($id);
        if ($subject->userId === Auth::id()){
            $request->validate([
                'input_subject_name' => 'required',
                'input_status' => 'required',
            ]);
            $subject->name = $request->input_subject_name;
            $subject->teacherName = $request->input_teacher_name;
            $subject->absenceMax = $request->input_max_absences;
            $subject->status = $request->input_status;
            $subject->isPrivate = $request->has('check_private') ? 1 : 0;
            $subject->save();
            return redirect()->route('subjects');
        }
        abort(403, "You cannot update someone else's subject");
    }

    public function increment($id){
        $subject = Subject::findOrFail($id);
        if ($subject->userId === Auth::id()){
            $subject->absenceNumber++;
            $subject->save();
            return $id . " incremented";
        }
        abort(403, "You cannot increment someone else's absences");
    }

    public function decrement($id){
        $subject = Subject::findOrFail($id);
        if ($subject->userId === Auth::id()){
            $subject->absenceNumber--;
            $subject->save();
            return $id . " decremented";
        }
        abort(403, "You cannot decrement someone else's absences");
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
