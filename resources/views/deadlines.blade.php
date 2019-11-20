@php
    if (isset($user)){
        $deadlines = App\Deadline::where('userId', $user->username)->get();
    }
@endphp

@extends('layouts.app')

@section('title')
    Tareas
@endsection

@section('content')
<div class="container">
    @isset($user)
        <h1 class="text-center mb-4">Tareas de {{$user->username}}</h1>
    @endisset
    <ul class="list-group w-75 mx-auto">
        @foreach($deadlines as $deadline)
        <li class="list-group-item" id="deadline-{{$deadline->id}}">
            <div class="row"> 
                <div class="col-4">
                    {{$deadline->name}}
                </div>
                <div class="col">
                    @isset($deadline->subjectId)
                    {{App\Subject::where('id', $deadline->subjectId)->first()->name}}
                    @endisset
                </div>
                <div class="col" id="remaining-{{$deadline->id}}"></div>
                <div class="col">{{date('d/m/Y', strtotime($deadline->end_hour))}}</div>
                <div class="col">
                    @isset($deadline->subject)
                    {{$deadline->subject}}
                    @endisset
                </div>
                <div class="col-1 text-center">
                @isset($user)
                    <button onclick="importDeadline({{$deadline->id}})" type="button" class="btn btn-sm btn-outline-secondary"><i class="fa fa-calendar-plus"></i></button>    
                @else
                <div class="dropdown">
                    <button class="btn btn-outline-secondary btn-sm" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fa fa-ellipsis-v"></i>
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <a class="dropdown-item text-danger" href="#" onclick="deleteDeadline({{$deadline->id}})"><i class="fa fa-trash"></i> Eliminar</a>                
                        <a class="dropdown-item text-dark" href="{{ route('deadlines.edit', $deadline->id) }}"><i class="fa fa-pen"></i> Editar</a>
                    </div>
                </div>                
                @endisset
                </div>
                <script>setTimer("{{$deadline->id}}", "{{$deadline->end_date}} {{$deadline->end_hour}}");</script>
            </div>     
        </li>
        @endforeach
    </ul>
    @isset($user)
    @else
    <a href="{{ route('deadlines.create') }}" class="btn btn-primary fixed-button">
        <i class="fa fa-plus"></i>
    </a>
    @endisset
</div>
@endsection