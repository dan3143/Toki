<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Deadline;

class DeadlineController extends Controller
{

    private $deadlines;

    public function index(Request $request){
        return view('deadlines', ['deadlines' => Deadline::where('userId', Auth::id())->get(), 'id'=>Auth::id()]);
    }
    

}
