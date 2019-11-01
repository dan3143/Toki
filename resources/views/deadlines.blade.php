@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            <span class="align-self-center">Tus tareas</span>
            <a href="{{ route('deadlines.create') }}" class="btn btn-sm btn-primary float-right">
                Nueva tarea
            </a>
        </div>
        <div class="card-body">
            <table class="table table-hover">
                <thead class="thead-dark">
                    <th>Nombre</th>
                    <th>Asignatura</th>
                    <th>Fecha límite</th>
                    <th>Hora límite</th>
                    <th>Prioridad</th>
                </thead>
                <tbody>
                @foreach($deadlines as $deadline)
                <tr>
                    <td> {{ $deadline->name }} </td>
                    <td> {{ App\Subject::where('id', $deadline->subjectId)->first()->name }} </td>
                    <td> {{ $deadline->end_date }} </td>
                    <td> {{ $deadline->end_hour}}
                    <td> {{ $deadline->priority}} </td>
                </tr>
                @endforeach
                </tbody>
                
            <table>
        </div>
    </div>
</div>
@endsection