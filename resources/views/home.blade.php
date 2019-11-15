@extends('layouts.app')

@section('title')
    Home
@endsection

@section('content')
<div class="container justify-content-center">
    @isset($deadlines)
    <div class="card mx-auto my-3" style="width: 40rem;">
        <div class="card-header text-white">Tareas más urgentes</div>
        <div class="card-body">
            <ul>
            @foreach($deadlines as $deadline)
                <li>{{$deadline->name}} ({{$deadline->end_date}})</li>
            @endforeach
            <ul>
        </div>
        <div class="card-footer"><a href="{{route('deadlines')}}">Ver</a></div>
    </div>
    @endisset
    <h3 class="text-center">Últimos posts</h3>
    @if(Auth::user()->role==='blogger')
    <a class="btn btn-primary btn-lg fixed-button" href="{{route('posts.create')}}">
        <i class="fa fa-plus"></i>
    </a>
    @endif
    @foreach ($posts as $post)
    <div class="card mx-auto my-3" id="card-{{$post->id}}" style="width: 40rem;">
        <div class="card-body" >
            <h4>{{$post->title}}</h4>
            <p>
                @php
                    $extract = substr(strip_tags(App\Post::format($post->content)), 0, 300);
                @endphp
                {!! $extract !!}... <a href="{{route('posts.show', $post->id)}}">Leer más</a>
            </p>
            @if (Auth::user()->role==='blogger')
            <button type="button" onclick="deletePost({{$post->id}})" class="btn btn-sm btn-outline-danger"><i class="fa fa-trash"></i></button>
            @endif
        </div>
    </div>
    @endforeach
</div>
@endsection