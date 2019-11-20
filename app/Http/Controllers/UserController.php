<?php

namespace App\Http\Controllers;

use App\Rules\MatchOldPassword;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;


class UserController extends Controller
{
    public function index(Request $request){
        return view('user');
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
        $user->description = $request->description;
        $user->save();
        return back();
    }


    public function change_password(){
        return view('change_password');
    }

    public function delete(){
        $id = Auth::id();
        Auth::logout();
        User::findOrFail($id)->delete();
        return redirect()->route('welcome');
    }    

    public function update_password(Request $request){
        $request->validate([
            'current_password' => ['required', new MatchOldPassword],
            'new_password' => 'required',
            'confirm_password' => 'required|same:new_password'
        ]);
        $user = User::findOrFail(Auth::id());
        $user->password = Hash::make($request->new_password);
        $user->save();
        return view('home');
    }
}