@extends('layouts.app')

@section('title')
    Tareas
@endsection

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            <span class ="align-self-center" >Tus tareas</span>
            <a href="{{ route('deadlines.create') }}" class="btn btn-sm btn-primary float-right">
                Nueva tarea
            </a>
            <div class="custom-control custom-switch float-right mr-4">
                <input type="checkbox" class="custom-control-input" id="show_dates">
                <label class="custom-control-label" for="show_dates">Mostrar fechas</label>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-hover">
                <thead >
                    <tr>
                        <th>Nombre</th>
                        <th style="text-align:center;">Asignatura</th>
                        <th style="text-align:center;">Fecha límite</th>
                        <th style="text-align:center;">Hora</th>
                        <th style="text-align:center;">Prioridad</th>
                        <th style="text-align:center;">Acción</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($deadlines as $deadline)
                <tr id="row-{{$deadline->id}}">
                    <td id="name-{{$deadline->id}}"> {{ $deadline->name }} </td>
                    <td class="text-center"> 
                        {{ $deadline->subjectId == null ? '--' : App\Subject::where('id', $deadline->subjectId)->first()->name }}
                    </td>
                    <td style="text-align:center;">
                        <span id="end_date" class="date">{{ date('d/m/Y', strtotime($deadline->end_date))}}</span>
                        <span class="parenthesis">(</span>
                        <span id="remaining-{{$deadline->id}}"></span>
                        <span class="parenthesis">)</span>
                        <script>setTimer("{{$deadline->id}}", "{{$deadline->end_date}} {{$deadline->end_hour}}");</script>
                     </td>
                    <td style="text-align:center;"> {{ date('h:i a', strtotime($deadline->end_hour))}}</td>
                    <td style="text-align:center;"> {{ $deadline->priority == 'low' ? 'Baja' :
                                                      ($deadline->priority == 'medium' ? 'Medianas' : 
                                                      ($deadline->priority == 'high' ? 'Alta' : '--'))}} </td>
                    <td width="10%" style="text-align:center;">
                        <button id="delete-{{$deadline->id}}" class="btn btn-sm btn-outline-danger" type="button">
                            <i class="fa fa-trash"></i>
                        </button>
                        <a class="btn btn-sm btn-outline-secondary" type="a" href="{{ route('deadlines.edit', $deadline->id) }}">
                            <i class="fa fa-pen"></i>
                        </a>
                    </td>
                </tr>
                <script>
                    $(document).ready(function(){
                        $("#delete-{{$deadline->id}}").click(function(){ deleteDeadline({{$deadline->id}}) });
                    });
                </script>
                @endforeach
                </tbody>  
            </table>
        </div>
    </div>
</div>
<script>
$(document).ready(function(){
    if($("#show_dates").prop("checked")){
        $(".date").show();
        $(".parenthesis").show();
    }else{
        $(".date").hide();
        $(".parenthesis").hide();
    }
    $("#show_dates").click(function(){
      console.log("hi");
      if($("#show_dates").prop("checked")){
          $(".date").show();
          $(".parenthesis").show();
      }else{
          $(".date").hide();
          $(".parenthesis").hide();
      }
  });
});
</script>
@endsection