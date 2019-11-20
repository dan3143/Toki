@extends('layouts.app')

@section('title')
    Rutina
@endsection

@section('content')
<div class="container">
    @isset($user)
        @php
         $activities = App\Activity::where('userId', $user->username)->where('day', $day)
                                                           ->orderBy('start_hour', 'asc')
                                                           ->get();     
        @endphp

        <p class="text-center h2">Rutina de {{$user->username}}</p>
        <nav aria-label="Days">
            <ul class="pagination justify-content-center">
                <li class="page-item {{$day=="sunday" ? 'active':''}}">
                    <a class="page-link" href="{{route('routine', ['day'=>'sunday', 'id'=>$user->username])}}">Domingo</a>
                </li>
                <li class="page-item {{$day=="monday" ? 'active':''}}">
                    <a class="page-link" href="{{route('routine', ['day'=>'monday', 'id'=>$user->username])}}">Lunes</a>
                </li>
                <li class="page-item {{$day=="tuesday" ? 'active':''}}">
                    <a class="page-link" href="{{route('routine', ['day'=>'tuesday', 'id'=>$user->username])}}">Martes</a>
                </li>
                <li class="page-item {{$day=="wednesday" ? 'active':''}}">
                    <a class="page-link" href="{{route('routine', ['day'=>'wednesday', 'id'=>$user->username])}}">Miércoles</a>
                </li>
                <li class="page-item {{$day=="thursday" ? 'active':''}} ">
                    <a class="page-link" href="{{route('routine', ['day'=>'thursday', 'id'=>$user->username])}}">Jueves</a>
                </li>
                <li class="page-item {{$day=="friday" ? 'active':''}}">
                    <a class="page-link" href="{{route('routine', ['day'=>'friday', 'id'=>$user->username])}}">Viernes</a>
                </li>
                <li class="page-item {{$day=="saturday" ? 'active':''}}">
                    <a class="page-link" href="{{route('routine', ['day'=>'saturday', 'id'=>$user->username])}}">Sábado</a>
                </li>
            </ul>
        </nav>
    @else
        <nav aria-label="Days">
            <ul class="pagination justify-content-center">
                <li class="page-item {{$day=="sunday" ? 'active':''}}">
                    <a class="page-link" href="{{route('routine', 'sunday')}}">Domingo</a>
                </li>
                <li class="page-item {{$day=="monday" ? 'active':''}}">
                    <a class="page-link" href="{{route('routine', 'monday')}}">Lunes</a>
                </li>
                <li class="page-item {{$day=="tuesday" ? 'active':''}}">
                    <a class="page-link" href="{{route('routine', 'tuesday')}}">Martes</a>
                </li>
                <li class="page-item {{$day=="wednesday" ? 'active':''}}">
                    <a class="page-link" href="{{route('routine', 'wednesday')}}">Miércoles</a>
                </li>
                <li class="page-item {{$day=="thursday" ? 'active':''}} ">
                    <a class="page-link" href="{{route('routine', 'thursday')}}">Jueves</a>
                </li>
                <li class="page-item {{$day=="friday" ? 'active':''}}">
                    <a class="page-link" href="{{route('routine', 'friday')}}">Viernes</a>
                </li>
                <li class="page-item {{$day=="saturday" ? 'active':''}}">
                    <a class="page-link" href="{{route('routine', 'saturday')}}">Sábado</a>
                </li>
            </ul>
        </nav>
    @endif

    @foreach ($activities as $activity)
        @if(!$activity->isPrivate || !isset($user))
        <div class="card mx-auto my-3" id="card-{{$activity->id}}" style="width: 25rem;">
            <div class="card-body">
                <h5>{{$activity->name}}</h5>
                <p>
                    @php
                        $start = date('g:i a', strtotime($activity->start_hour));
                        $end = date('g:i a', strtotime($activity->end_hour));
                    @endphp
                    <b>Hora:</b> <span id="start_hour">{{$start}}</span> @isset($activity->end_hour) a <span id="end_hour">{{$end}}</span> @endisset
                    <br>
                    @isset($activity->place)
                    <b>Dónde:</b> {{$activity->place}}
                    @endisset
                </p>
                @isset($user)
                    <button onclick="importActivity({{$activity->id}})" type="button" class="btn btn-sm btn-outline-secondary"><i class="fa fa-calendar-plus"></i></button>    
                @else
                    <button type="button" onclick="deleteActivity({{$activity->id}})" class="btn btn-sm btn-outline-danger btn-delete"><i class="fa fa-trash"></i></button>
                    <a class="edit_link btn btn-sm btn-outline-secondary" data-toggle="modal" href="#modal_edit"
                        data-id="{{$activity->id}}"
                        data-name="{{$activity->name}}"
                        data-start-hour="{{$activity->start_hour}}"
                        data-end-hour="{{$activity->end_hour}}"
                        data-place="{{$activity->place}}">
                        <i class="fa fa-pen"></i>
                    </a>
                @endisset
            </div>
        </div>
        <script>
            start_hour = new Date("{{date('Y-m-d H:i:s', strtotime($activity->start_hour))}}").getTime();
            end_hour = new Date("{{date('Y-m-d H:i:s', strtotime($activity->end_hour))}}").getTime();
            now = new Date().getTime();
            console.log("start_hour: " + start_hour);
            if (now >= start_hour && now < end_hour){
                card = $("#card-{{$activity->id}}");
                
                //fondo
                card.css("background-color", "#C2EABD");
                
                //texto
                //card.css("color", "#FFFAFF");
                
                //botón editar
                //$("#card-{{$activity->id}} .edit_link").toggleClass("btn-outline-light btn-outline-secondary");
                
                //botón borrar
                //$("#card-{{$activity->id}} .btn-delete").css("color", "#FC5130");
            }
        </script>
        @endif
    @endforeach
    @isset($user)
    @else
    <button class="btn btn-primary btn-lg fixed-button" data-toggle="modal" data-target="#modal_add">
        <i class="fa fa-plus"></i>
    </button>
    @endisset
</div>

<div class="modal fade" id="modal_add" tabindex="-1" role="dialog" aria-labelledby="addModal" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Agregar actividad</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <form method="post" action="{{ route('routine.store', $day) }}" id="form" onsubmit="disableSubmit()">
            @csrf
            <div class="modal-body">
                <div class="form-group">
                    <label for="input_name">Nombre</label>
                    <input type="text" name="input_name" class="form-control @error('input_name') is-invalid @enderror" 
                        placeholder="Ingresa el nombre de la actividad"
                        value="{{old('input_name')}}">
                    @error('input_name')
                    <small class="text-danger">Campo requerido</small>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="input_place">Lugar</label>
                    <input id="input_place" type="text" name="input_place" class="form-control @error('input_place') is-invalid @enderror" 
                        placeholder="Ingresa el lugar donde harás la actividad"
                        value="{{old('input_place')}}">
                </div>
                <div class="form-group">
                    <label for="input_start_hour">Hora de inicio</label>
                    <input id="input_start_hour" type="time" name="input_start_hour" class="form-control @error('input_start_hour') is-invalid @enderror" 
                        placeholder="Ingresa el lugar donde harás la actividad"
                        value="{{old('input_start_hour')}}">
                    @error('input_start_hour')
                        <small class="text-danger">La hora de inicio no debe ser mayor a la de fin</small>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="input_end_hour">Hora de fin</label>
                    <input id="input_end_hour" type="time" name="input_end_hour" class="form-control @error('input_end_hour') is-invalid @enderror" 
                        placeholder="Ingresa el lugar donde harás la actividad"
                        value="{{old('input_end_hour')}}">
                    @error('input_end_hour')
                        <small class="text-danger">La hora de inicio no debe ser mayor a la de fin</small>
                    @enderror
                </div>
                <div class="form-check">
                    <label class="form-check-label">
                        <input type="checkbox" class="form-check-input" id="repeat" name="repeat">Repetir
                    </label>
                </div>

                <div id="repeat-section" class="btn-group-toggle text-center" data-toggle="buttons">
                    <label class="btn btn-light">
                        <input type="checkbox" autocomplete="off" name="sunday">D
                    </label>

                    <label class="btn btn-secondary active">
                        <input type="checkbox" autocomplete="off" checked name="monday">L
                    </label>
                    
                    <label class="btn btn-secondary active">
                        <input type="checkbox" autocomplete="off" checked name="tuesday">M
                    </label>
                
                    <label class="btn btn-secondary active">
                        <input type="checkbox" autocomplete="off"  checked name="wednesday">X
                    </label>
                
                    <label class="btn btn-secondary active">
                        <input type="checkbox" autocomplete="off" checked name="thursday">J
                    </label>

                    <label class="btn btn-secondary active">
                        <input type="checkbox" autocomplete="off" checked name="friday">V
                    </label>

                    <label class="btn btn-light">
                        <input type="checkbox" autocomplete="off" name="saturday">S
                    </label>
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

<div class="modal fade" id="modal_edit" tabindex="-1" role="dialog" aria-labelledby="addModal" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Editar actividad</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <form method="post" action="{{ route('routine.update', $day) }}" id="form" onsubmit="disableSubmit()">
            @csrf
            @method('PUT')
            <div class="modal-body" id="modal_edit_body">
                <input hidden type="number" name="id" id="id" value="">
                <div class="form-group">
                    <label for="input_name">Nombre</label>
                    <input type="text" id="input_name" name="input_name" class="form-control @error('input_name') is-invalid @enderror" 
                        placeholder="Ingresa el nombre de la actividad"
                        value="">
                    @error('input_name')
                    <small class="text-danger">Campo requerido</small>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="input_place">Lugar</label>
                    <input type="text" id="input_place" name="input_place" class="form-control @error('input_place') is-invalid @enderror" 
                        placeholder="Ingresa el lugar donde harás la actividad"
                        value="">
                </div>
                <div class="form-group">
                    <label for="input_start_hour">Hora de inicio</label>
                    <input id="input_start_hour" type="time" name="input_start_hour" class="form-control @error('input_start_hour') is-invalid @enderror" 
                        placeholder="Ingresa la hora a la que comenzará la actividad"
                        value="">
                </div>
                <div class="form-group">
                    <label for="input_end_hour">Hora de fin</label>
                    <input id="input_end_hour" type="time" name="input_end_hour" class="form-control @error('input_end_hour') is-invalid @enderror" 
                        placeholder="Ingresa la hora a la que terminará la actividad"
                        value="">
                </div>
            </div>
            <div class="modal-footer">
                <input type="submit" class="btn btn-primary" value="Actualizar">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>        
            </div>
        </form>
    </div>
  </div>
</div>

<script>
    $(document).on("click", ".edit_link", function(){
        var id = $(this).data('id');
        var name = $(this).data('name');
        var start_hour = $(this).data('start-hour');
        var end_hour = $(this).data('end-hour');
        var place = $(this).data('place');
        $("#modal_edit_body #id").val(id);
        $("#modal_edit_body #input_name").val(name);
        $("#modal_edit_body #input_start_hour").val(start_hour);
        $("#modal_edit_body #input_end_hour").val(end_hour);
        $("#modal_edit_body #input_place").val(place);
    });

    $(document).ready(function(){

        $("#repeat-section").hide();
        $("#repeat").change(function(){
            if (this.checked){
                $("#repeat-section").show();
            } else {
                $("#repeat-section").hide();
            }
        });
        $('[data-toggle="buttons"] .btn').on('click', function () {
            $(this).toggleClass('btn-secondary btn-light active');
            var $chk = $(this).find('[type=checkbox]');
            var value = !$chk.prop('checked');
            console.log(value);
            $chk.prop('checked', value);
            return false;
        });

    });
</script>

@endsection