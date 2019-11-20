<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class SearchController extends Controller
{
    public function index(Request $request){
        $users = User::where('username', 'like', $request->search_query . "%")->orderBy('username', 'asc')->get();
        return view('search', ['results' => $users, 'query' => $request->search_query]);
    }
}
