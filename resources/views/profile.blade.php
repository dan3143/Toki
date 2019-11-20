@extends('layouts.app')

@section('title')
    Perfil de {{$user->username}}
@endsection

@section('content')
<div class="container">
    <div class="card mx-auto w-75">
        <div class="card-body">
            <div class="row justify-content-center">
                <img class="rounded-circle" src="/storage/avatars/{{$user->profile_picture}}" width="200" height="200">
            </div>
    
            <div class="row justify-content-center mt-3">
                <span class="h4">{{$user->name}} ({{$user->username}})</span>
            </div>

            <div class="row justify-content-center">
               {{$user->description}}
            </div>
            
            <div class="row justify-content-center mt-3">
                <a class="btn btn-sm btn-light mx-1" href="{{route('deadlines', $user->username)}}">Tareas de {{$user->username}}</a>
                <a class="btn btn-sm btn-light mx-1" href="{{route('routine', ["id"=>$user->username,"day"=>"monday"])}}">Rutina de {{$user->username}}</a>
                <a class="btn btn-sm btn-light mx-1" href="{{route('subjects', $user->username)}}">Asignaturas de {{$user->username}}</a>
            </div>
        </div>
    <div>
</div>
@endsection
