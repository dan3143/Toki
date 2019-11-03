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
                <thead >
                    <tr>
                        <th>Nombre</th>
                        <th>Asignatura</th>
                        <th style="text-align:center;">Fecha límite</th>
                        <th style="text-align:center;">Hora límite</th>
                        <th style="text-align:center;">Prioridad</th>
                        <th style="text-align:center;">Acción</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($deadlines as $deadline)
                <tr>
                    <td> {{ $deadline->name }} </td>
                    <td> {{ App\Subject::where('id', $deadline->subjectId)->first()->name }} </td>
                    <td style="text-align:center;"> 
                        <span id="end_date">{{ $deadline->end_date }}</span>
                        <span id="remaining"></span>
                        <script>remainingDays('{{$deadline->end_date}}' + ' ' +  '{{$deadline->end_hour}}');</script>
                     </td>
                    <td style="text-align:center;"> {{ $deadline->end_hour}}
                    <td style="text-align:center;" width="5%"> {{ $deadline->priority == 'low' ? 'Baja' :
                            ($deadline->priority == 'medium' ? 'Mediana' : 'Alta')}} </td>
                    <td width="10%">
                        <button class="btn btn-sm btn-outline-danger" type="button"
                            onclick="confirm('¿De verdad quieres eliminar esta actividad?') ? document.getElementById('delete-{{$deadline->id}}').submit() : false;">
                            <i class="fa fa-trash"></i>
                        </button>
                        <a class="btn btn-sm btn-outline-secondary" type="button" href="{{ route('deadlines.edit', $deadline->id) }}">
                            <i class="fa fa-pen"></i>
                        </a>
                        <form id="delete-{{$deadline->id}}" 
                            action="{{route('deadlines.delete', $deadline->id)}}" 
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