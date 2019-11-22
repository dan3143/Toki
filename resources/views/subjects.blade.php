@php
    use Illuminate\Support\Facades\Auth;
    if (isset($user)){
        $subjects = App\Subject::where('userId', $user->username)->get();
    }
@endphp

@extends('layouts.app')

@section('title')
    Asignaturas @isset($user) de {{$user->username}} @endisset
@endsection

@section('content')
<div class="container">
    <div class="card mx-auto">
        <div class="card-header">
            <span class="align-self-center">Tus asignaturas</span>
            <a href="{{ route('subjects.create') }}" class="btn btn-sm btn-primary float-right">
                Nueva asignatura
            </a>
        </div>
        <div class="card-body">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Profesor</th>
                        <th style="text-align:center;">Inasistencias</th>
                        <th style="text-align:center;">Acción</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($subjects as $subject)
                <tr id="row-{{$subject->id}}">
                    <td> {{$subject->name}} </td>
                    <td> {{$subject->teacherName}} </td>
                    <td width="15%" style="text-align:center;"> 
                        @isset($user)
                        @else
                        <button onclick="decrement({{$subject->id}})" class="btn btn-xs btn-outline-secondary" type="button">
                            <i class="fa fa-minus"></i>
                        </button>
                        @endisset
                        <span id="absenceNumber-{{$subject->id}}">{{$subject->absenceNumber}}</span>@isset($subject->absenceMax)/{{$subject->absenceMax}}@endisset
                        @isset($user)
                        @else
                        <button onclick="increment({{$subject->id}})" class="btn btn-xs btn-outline-secondary" type="button">
                            <i class="fa fa-plus"></i>
                        </button>
                        @endisset
                    </td>
                    <td style="text-align:center;">
                        @isset($user)
                            <button onclick="subscribeToSubject({{$subject->id}})" type="button" class="btn btn-sm btn-outline-secondary"><i class="fa fa-calendar-plus"></i></button>
                        @else
                            <button onclick="deleteSubject({{$subject->id}})" class="btn btn-sm btn-outline-danger" type="button">
                                <i class="fa fa-trash"></i>
                            </button>
                            <a class="btn btn-sm btn-outline-secondary" type="a" href="{{ route('subjects.edit', $subject->id) }}">
                                <i class="fa fa-pen"></i>
                            </a>
                            <a class="btn btn-sm btn-outline-info" type="a" href="{{ route('subjects.show', $subject->id) }}">
                                <i class="fa fa-info"></i>
                            </a>
                        @endisset
                    </td>
                </tr>
                @endforeach
                </tbody>  
            </table>
        </div>
    </div>
</div>

@endsection