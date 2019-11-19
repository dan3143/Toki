<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Mail;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class MailController extends Controller {
   public function basic_email() {
      $headers = 'From: Toki @';
      $user = Auth::user();
      $to = $user ->email;
      $name = $user->name;
      mail($to,"¡Hola $name!","Esto es una prueba o(≧▽≦)o",$headers);
      return redirect()->route('user');;
   }
   
}
