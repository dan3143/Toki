@php
    if (isset($user)){
        $subjects = App\Subject::where('userId', $user->username)->get();
    }
@endphp

@extends('layouts.app')

@section('title')
    Asignaturas
@endsection

@section('content')
<div class="container">
    <ul class="list-group w-75 mx-auto">
        @foreach($subjects as $subject)    
        <li class="list-group-item" id="subject-{{$subject->id}}">
            <div class="row">
                <div class="col-4">{{$subject->name}}</div>
                <div class="col">{{$subject->teacherName}} </div>
                <div class="col">
                    <button  class="btn btn-xs btn-outline-secondary" onclick="decrement({{$subject->id}})">
                        <i class="fa fa-minus"></i>
                    </button>
                    <span id="absenceNumber-{{$subject->id}}">{{$subject->absenceNumber}}</span>@isset($subject->absenceMax)/{{$subject->absenceMax}}@endisset
                    <button class="btn btn-xs btn-outline-secondary" onclick=" increment( {{$subject->id}})">
                        <i class="fa fa-plus"></i>
                    </button>
                </div>
                <div class="col-1 text-center">
                @isset($user)
                <button onclick="importSubject({{$subject->id}})" type="button" class="btn btn-sm btn-outline-secondary"><i class="fa fa-calendar-plus"></i></button>    
                @else
                <div class="dropdown">
                    <button class="btn btn-outline-secondary btn-sm" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fa fa-ellipsis-v"></i>
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <a class="dropdown-item text-danger" href="#" onclick="deleteSubject({{$subject->id}})"><i class="fa fa-trash"></i> Eliminar</a>                
                        <a class="dropdown-item text-dark" href="{{ route('subjects.edit', $subject->id) }}"><i class="fa fa-pen"></i> Editar</a>
                        <a class="dropdown-item text-dark" href="{{ route('subjects.show', $subject->id) }}"><i class="fa fa-info-circle"></i> Detalles</a>
                    </div>
                </div>                
                @endisset
                </div>
            </div>     
        </li>
        @endforeach
    </ul>
    @isset($user)
    @else
    <a href="{{ route('subjects.create') }}" class="btn btn-primary fixed-button">
        <i class="fa fa-plus"></i>
    </a>
    @endisset
</div>
@endsection