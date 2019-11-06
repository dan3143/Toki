@extends('layouts.app')

@section('content')
<div class="container">
    <header class="header bg-primary text-white p-4 mx-5">
        <div class="row">
            <div class="col"><h1>{{ $subject->name }}</h1></div>
        </div>
        <div class="row">
            <div class="col">Profesor(es): {{$subject->teacherName}}</div>
            <div class="col">Estado: {{$subject->status}}</div>
            <div class="col">Inasistencias: {{$subject->absenceNumber}}@isset($subject->absenceMax)/{{$subject->absenceMax}}@endisset</div>
            <div class="col">Porcentaje definido: <span id="defined">{{$defined}}</span></div>
        </div>
    </header>
    <div class="panel-body mx-5 mt-4 px-4 py-2 border">
        <h3 class="p-4 ">Notas</h3>
        <div class="p-4 justify-content-center">
            <table class="table border" id="grades_table">
                <thead class="text-center thead-dark">
                    <tr>
                        <th class="h5">Valor</th>
                        <th class="h5">Porcentaje</th>
                        <th></th>
                    </tr>
                </thead>
                @foreach($grades as $grade)
                <tr class="text-center" id="row-{{$grade->id}}">
                    <td>{{$grade->value}}</td>
                    <td>{{$grade->percentage}} %</td>
                    <td>&nbsp;&nbsp;<button id="delete_grade_{{$grade->id}}" class="btn btn-outline-danger btn-sm text-center"><i class="fa fa-times-circle"></i></button></td>
                </tr>
                <script>
                    $(document).ready(function(){
                        $('#delete_grade_{{$grade->id}}').click(function(){ deleteGrade({{$grade->subjectId}}, {{$grade->id}}, {{$grade->percentage}}) });
                    });
                </script>
                @endforeach
                <tr>
                    <td colspan="3" class="text-center">
                        <button @if($defined == 100) hidden @endif id="agregar_nota" type="button" class="btn btn-outline-primary" data-toggle="modal" data-target="#modal_add">
                            <i class="fa fa-plus"></i> Agregar nota
                        </button>
                    </td>
                    
                </tr>
                <tr>
                    <td colspan="3" class="text-center">
                        <p>Tienes la materia en: <span id="current_grade">{{$current_grade}}</span>
                    </td>
                </tr>
            </table>
            <label for="minimum">Quiero dejar la materia en:</label>
            <input value="3" name="minimum" step="0.01" type="number" min="0" max="5" id="minimum" placeholder="Nota mínima">
            <button class="btn btn-sm btn-outline-secondary" type="button" id="calculate">Calcular</button>
        </div>
        
    </div>            
</div>

<div class="modal fade" id="modal_add" tabindex="-1" role="dialog" aria-labelledby="addModal" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="addModal">Agregar nota</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <form method="post" action="{{ route('subjects.add_grade', $subject->id) }}" id="form" onsubmit="disableSubmit()">
            @csrf
            <div class="modal-body">
                <div class="form-group">
                    <label for="input_value">Valor</label>
                    <input type="number" min="0" max="5" step="0.01" name="input_value" class="form-control @error('input_value') is-invalid @enderror" 
                        placeholder="Ingresa el valor de la nota"
                        value="{{old('input_value')}}">
                    @error('input_value')
                    <small class="text-danger">Campo requerido</small>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="input_percentage">Porcentaje</label>
                    <input id="input_percentage" type="number" min="0" max="{{100-$defined}}" name="input_percentage" class="form-control @error('input_percentage') is-invalid @enderror" 
                        placeholder="Ingresa el valor de la nota"
                        value="{{old('input_percentage')}}">
                    @error('input_percentage')
                    <small class="text-danger">Campo requerido</small>
                    @enderror
                </div>
            </div>
            <div class="modal-footer">
                <input type="submit" class="btn btn-primary" value="Agregar">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>        
            </div>
        </form>
    </div>
  </div>
</div>

<div class="modal fade" id="needed_grade_modal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="addModal">Agregar nota</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
          <p id="calculation"></p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>

<script>
    $(document).ready(function(){
        $("#calculate").click(function(){
            $.ajax({
                url: "{{ route('subjects.get_sum', $subject->id) }}",
                method:"GET",
                headers: {'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')},
                success: function(result){ 
                    result = JSON.parse(result);
                    var min = $("#minimum").val();
                    var grade = ((min-result.sum)/result.percentage).toFixed(2);
                    var message = "";
                    if (grade > 5){
                        message = "Desafortunadamente es imposible dejar la materia en " + min;
                        message += "<br>Necesitarías " + grade;
                    }else if (grade > 4){
                        message = "Todavía se puede!<br>Necesitarás sacar " + grade + " de ahora en adelante";
                    }else if (grade > 0){
                        message = "Necesitarás sacar " + grade + " en todo de ahora en adelante";
                    } else {
                        message = "Ya ganaste la materia. Esfuérzate para dejarla alta, de todos modos";
                    }
                    $("#calculation").html(message);
                    $("#needed_grade_modal").modal();
                },
                error: function(xhr){ console.log("Ocurrió un error:  " + xhr.status); }
            });;
        });
    });
</script>
@endsection