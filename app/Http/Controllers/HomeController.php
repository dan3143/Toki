<?php

namespace App\Http\Controllers;

use App\Post;
use App\Deadline;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home', ['posts' => Post::orderBy('updated_at')->get(), 
                             'deadlines' => Deadline::orderBy('end_date', 'DESC')->take(5)->get()]);
    }
}
