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
                <thead>
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
                <tr id="row-{{$subject->id}}">
                    <td> {{$subject->name}} </td>
                    <td> {{$subject->teacherName}} </td>
                    <td width="15%" style="text-align:center;"> 
                        <button id="decrement-{{$subject->id}}" class="btn btn-xs btn-outline-secondary" type="button">
                            <i class="fa fa-minus"></i>
                        </button>
                        <span id="absenceNumber-{{$subject->id}}">{{$subject->absenceNumber}}</span>@isset($subject->absenceMax)/{{$subject->absenceMax}}@endisset
                        <button id="increment-{{$subject->id}}" class="btn btn-xs btn-outline-secondary" type="button">
                            <i class="fa fa-plus"></i>
                        </button>
                    </td>
                    <td style="text-align:center;">
                        {{$subject->status == 'studying' ? 'estudiando' :
                          ($subject->status == 'finished' ? 'finalizada' : 'retirada')}}
                    </td>
                    <td style="text-align:center;">
                        <button id="delete-{{$subject->id}}" class="btn btn-sm btn-outline-danger" type="button">
                            <i class="fa fa-trash"></i>
                        </button>
                        <a class="btn btn-sm btn-outline-secondary" type="a" href="{{ route('subjects.edit', $subject->id) }}">
                            <i class="fa fa-pen"></i>
                        </a>
                    </td>
                    <script>
                        $(document).ready(function(){
                            $("#delete-{{$subject->id}}").click(function(){
                                if (confirm("¿De verdad quieres eliminar esta asignatura?")){
                                    row = $("#row-{{$subject->id}} td");
                                    $.ajax({
                                        url: "subjects/{{$subject->id}}/delete",
                                        method:"DELETE",
                                        headers: {'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')},
                                        success: function(result){
                                            row.hide();
                                            row.remove();
                                        },
                                        error: function(xhr){
                                            console.log("Ocurrió un error:  " + xhr);
                                        }
                                    });
                                }
                            });
                            $("#increment-{{$subject->id}}").click(function(){
                                absences = $("#absenceNumber-{{$subject->id}}");
                                value = parseInt(absences.text(), 10);
                                $.ajax({
                                    url: "subjects/{{$subject->id}}/increment",
                                    method: "put",
                                    headers: {'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')},
                                    success: function(result){
                                        value++;
                                        absences.text(value);
                                    },
                                    error: function(xhr){
                                        console.log("Ocurrió un error:  " + xhr.status);
                                    }
                                });
                            });
                            $("#decrement-{{$subject->id}}").click(function(){
                                absences = $("#absenceNumber-{{$subject->id}}");
                                value = parseInt(absences.text(), 10);
                                $.ajax({
                                    url: "subjects/{{$subject->id}}/increment",
                                    method: "put",
                                    headers: {'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')},
                                    success: function(result){
                                        if (value > 0){
                                            value--;
                                        }
                                        absences.text(value);
                                    },
                                    error: function(xhr){
                                        console.log("Ocurrió un error:  " + xhr.status);
                                    }
                                });
                            });
                        });
                    </script>
                </tr>
                @endforeach
                </tbody>  
            </table>
        </div>
    </div>
</div>

@endsection