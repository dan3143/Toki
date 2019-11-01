<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CreateDeadlineController extends Controller
{
    public function index(Request $request){
        return view('create_deadline');
    }
}
