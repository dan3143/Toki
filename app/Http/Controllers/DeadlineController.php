<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Deadline;
use App\Subject;
use App\User;
use App\Subscription;

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
        $deadline->isPrivate = $request->has('check_private') ? 1 : 0;
        $deadline->save();
        $subscriptions = Subscription::where('providerSubjectId', $deadline->subjectId)->get();
        foreach($subscriptions as $subscription){
            $newDeadline = new Deadline;
            $newDeadline->userId = $subscription->subscriberId;
            $newDeadline->name = $request->input_deadline_name;
            $newDeadline->end_date = $request->input_date;
            $newDeadline->end_hour = $request->input_time;
            $newDeadline->subjectId = $request->subscriberSubjectId;
            $newDeadline->priority = $request->input_priority;
            $newDeadline->isPrivate = $request->has('check_private') ? 1 : 0;
            $newDeadline->save();
        }
        return redirect()->route('deadlines');
    }

    public function delete($id){
        $deadline = Deadline::findOrFail($id);
        if($deadline->userId === Auth::id()){
            Deadline::findOrFail($id)->delete();
            return $id . " deleted";
        }
        abort(403, "You can't delete someone else's deadline");
    }

    public function edit($id){
        $deadline = Deadline::findOrFail($id);
        if($deadline->userId === Auth::id()){
            return view('edit_deadline', ['deadline' => $deadline, "subjects" => Subject::where('userId', Auth::id())->get()]);
        }
        abort(403, "You cannot edit someone else's deadline");
    }

    public function update(Request $request, $id){
        $deadline = Deadline::findOrFail($id);
        if (Auth::id() === $deadline->userId){
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
            $deadline->isPrivate = $request->has('check_private') ? 1 : 0;
            $deadline->save();
            return redirect()->route('deadlines');
        }
        abort(403, "You can't update someone else's deadline");
    }

    public function import($id){
        $deadline = Deadline::findOrFail($id);
        if (!$deadline->isPrivate){
            $imported = new Deadline;
            $imported->userId = Auth::id();
            $imported->name = $deadline->name;
            $imported->end_date = $deadline->end_date;
            $imported->end_hour = $deadline->end_hour;
            $imported->subjectId = $deadline->subjectId;
            $imported->priority = $deadline->priority;
            $imported->isPrivate = $deadline->isPrivate;
            $imported->save();
            return $id . " imported";
        }
        abort(403, "You cannot import private deadlines");
    }

}
