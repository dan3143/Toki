<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index(Request $request){
        return view('profile');
    }

    public function update(Request $request){
        $user = Auth::user();
        $request->validate([
            'pic' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'name' => 'required',
            'email' => 'required|unique:users,email,'.Auth::id().',username|email'
        ]);
        $messages = [
            'name.required' => 'El campo de nombre es obligatorio',
            'email.required' => 'El campo de email es obligatorio',
            'email.unique' => 'El email debe ser único',
            'email.email' => 'Ingresa una dirección de correo válida'
        ];
        
        if ($request->hasFile('pic')){
            if ($user->profile_picture !== 'user.png'){
                Storage::delete('avatars/'.$user->profile_picture);
            }
            $filename = Auth::id() . '_avatar' . time() . '.' . $request->pic->getClientOriginalExtension();
            $request->pic->storeAs('avatars', $filename);
            $user->profile_picture = $filename;    
        }
        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();
        return back();
    }

}