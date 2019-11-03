@extends('layouts.app')
@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            <span class="align-self-center">Tus asignaturas</span>
            <a href="{{ route('subjects.create') }}" class="btn btn-sm btn-primary float-right">
                Nueva asignatura
            </a>
        </div>
        <div class="card-body">
            <table class="table table-hover">
                <thead >
                    <tr>
                        <th>Nombre</th>
                        <th>Profesor</th>
                        <th style="text-align:center;">Inasistencias</th>
                        <th style="text-align:center;">Estado</th>
                        <th style="text-align:center;">Acción</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($subjects as $subject)
                <tr>
                    <td> {{$subject->name}} </td>
                    <td> {{$subject->teacherName}} </td>
                    <td width="15%" style="text-align:center;"> 
                        <form class="form-horizontal" method="POST" action="{{ route('subjects.decrement', $subject->id)}}"
                            style="float:left">
                            @csrf
                            @method('put')
                            <button name="decrement" class="btn btn-xs btn-outline-secondary" type="submit">
                                <i class="fa fa-minus"></i>
                            </button>
                        </form>
                        {{$subject->absenceNumber}}/{{$subject->absenceMax}}  
                        <form class="form-horizontal" method="POST" action="{{ route('subjects.increment', $subject->id) }}"
                            style="float: right;">
                            @csrf
                            @method('put')
                            <button name="increment" class="btn btn-xs btn-outline-secondary" type="submit">
                                <i class="fa fa-plus"></i>
                            </button>
                        </form>
                    </td>
                    <td style="text-align:center;">
                        {{$subject->status == 'studying' ? 'estudiando' :
                          ($subject->status == 'finished' ? 'finalizada' : 'retirada')}}
                    </td>
                    <td style="text-align:center;">
                        <button class="btn btn-sm btn-outline-danger" type="button"
                            onclick="confirm('¿De verdad quieres eliminar esta asignatura?') ? document.getElementById('delete-{{$subject->id}}').submit() : false;">
                            <i class="fa fa-trash"></i>
                        </button>
                        <a class="btn btn-sm btn-outline-secondary" type="a" href="{{ route('subjects.edit', $subject->id) }}">
                            <i class="fa fa-pen"></i>
                        </a>
                        <form id="delete-{{$subject->id}}" 
                            action="{{route('subjects.delete', $subject->id)}}" 
                            method="POST">
                            @method('delete')
                            @csrf
                        </form>
                    </td>
                </tr>
                @endforeach
                </tbody>  
            </table>
        </div>
    </div>
</div>
@endsection