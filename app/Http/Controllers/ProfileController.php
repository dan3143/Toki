<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class ProfileController extends Controller
{
    public function index($id){
        return view('profile', ['user' => User::findOrFail($id)]);
    }
}
