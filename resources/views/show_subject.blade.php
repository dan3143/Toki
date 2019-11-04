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
                        $('#delete_grade_{{$grade->id}}').click(function(){
                            if (confirm("¿De verdad quieres eliminar esta nota?")){
                                row = $("#row-{{$grade->id}} td");
                                percentage = {{$grade->percentage}};
                                $.ajax({
                                    url: "{{ route('subjects.delete_grade', $grade->id) }}",
                                    method:"DELETE",
                                    headers: {'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')},
                                    success: function(result){
                                        value = parseInt($('#defined').text(), 10);
                                        value -= percentage;
                                        $("#defined").text(value);
                                        row.hide();
                                        row.remove();
                                    },
                                    error: function(xhr){
                                        console.log("Ocurrió un error:  " + xhr.status);
                                    }
                                });
                            }
                        });
                    });
                </script>
                @endforeach
                <tr>
                    @if($defined < 100)
                        <td colspan="3" class="text-center">
                            <button type="button" class="btn btn-outline-primary" data-toggle="modal" data-target="#modal_add">
                                <i class="fa fa-plus"></i> Agregar nota
                            </button>
                        </td>
                    @endif
                </tr>
            </table>
            
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
        <form method="post" action="{{ route('subjects.add_grade', $subject->id) }}">
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
                    <input type="number" min="0" max="{{100-$defined}}" name="input_percentage" class="form-control @error('input_percentage') is-invalid @enderror" 
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

@endsection