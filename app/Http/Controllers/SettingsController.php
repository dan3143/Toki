<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function index(Request $request){
        return view('settings');
    }

    public function picture(Request $request){
        $request->validate([
            'pic' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);
        $user = Auth::user();
        if ($user->profile_picture !== 'user.png'){
            Storage::delete('avatars/'.$user->profile_picture);
        }
        $filename = Auth::id() . '_avatar' . time() . '.' . $request->pic->getClientOriginalExtension();
        $request->pic->storeAs('avatars', $filename);
        $user->profile_picture = $filename;
        $user->save();
        return back();
    }

}