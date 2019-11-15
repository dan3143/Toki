<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function show(Request $request, $id){
        $post = Post::findOrFail($id);
        return view('post', ['post' => $post]);
    }

    public function create(Request $request){
        return view('create_post');
    }

    public function edit(Request $request, $id){
        return view('edit_post', ['post'=>Post::findOrFail($id)]);
    }

    public function delete($id){
        Post::findOrFail($id)->delete();
        return $id . " deleted";
    }

    public function store(Request $request){
        $request->validate([
            'title' => 'required',
            'content' => 'required'
        ]);
        $post = new Post;
        $post->title = $request->title;
        $post->content = $request->content;
        $post->posterId = Auth::id();
        $post->save();
        return redirect()->route('home');
    }

    public function update(Request $request, $id){
        $request->validate([
            'title' => 'required',
            'content' => 'required'
        ]);
        $post = findOrFail($id);
        $post->title = $request->title;
        $post->content = $request->content;
        $post->save();
        return redirect()->route('home');
    }

    
}
