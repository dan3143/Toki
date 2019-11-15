@extends('layouts.app')
@php
use App\Post;    
use App\User;
@endphp


@section('title')
    {{$post->title}}
@endsection

@section('content')
<div class="container">
    <div class="card mx-auto" style="width: 50rem;">
        <div class="card-body">
            <p class="h1">{{$post->title}}</p>
            <hr>
            <div style="font-size:15px">
                {!! Post::format($post->content) !!}
            </div>
            <br>
            
        </div>
        <div class="card-footer">
            Creado por {{User::findOrFail($post->posterId)->name}}
        </div>
    </div>
</div>
@endsection