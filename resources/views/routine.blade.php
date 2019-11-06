@extends('layouts.app')
@section('content')
<div class="container">
    <nav aria-label="Days" >
        <ul class="pagination justify-content-center">
            <li class="page-item {{$day=="sunday" ? 'active':''}}"><a class="page-link" href="{{route('routine', 'sunday')}}">Domingo</a></li>
            <li class="page-item {{$day=="monday" ? 'active':''}}"><a class="page-link" href="{{route('routine', 'monday')}}">Lunes</a></li>
            <li class="page-item {{$day=="tuesday" ? 'active':''}}"><a class="page-link" href="{{route('routine', 'tuesday')}}">Martes</a></li>
            <li class="page-item {{$day=="wednesday" ? 'active':''}}"><a class="page-link" href="{{route('routine', 'wednesday')}}">Miércoles</a></li>
            <li class="page-item {{$day=="thursday" ? 'active':''}} "><a class="page-link" href="{{route('routine', 'thursday')}}">Jueves</a></li>
            <li class="page-item {{$day=="friday" ? 'active':''}}"><a class="page-link" href="{{route('routine', 'friday')}}">Viernes</a></li>
            <li class="page-item {{$day=="saturday" ? 'active':''}}"><a class="page-link" href="{{route('routine', 'saturday')}}">Sábado</a></li>
        </ul>
    </nav>
    @foreach ($activities as $activity)
    <div class="card mx-auto my-3" id="card-{{$activity->id}}" style="width: 25rem;">
        <div class="card-body" >
            <h5>{{$activity->name}}</h5>
            <p>
                @php
                    $start = date('g:i a', strtotime($activity->start_hour));
                    $end = date('g:i a', strtotime($activity->end_hour));
                @endphp
                <b>Hora:</b> {{$start}} a {{$end}}
                <br>
                <b>Dónde:</b> {{$activity->place}}
            </p>
            <button type="button" onclick="deleteCard({{$activity->id}})" class="btn btn-sm btn-outline-danger"><i class="fa fa-trash"></i></button>
            <a href="#" class="btn btn-sm btn-outline-secondary"><i class="fa fa-pen"></i></a>
        </div>
    </div>
    @endforeach
    <button class="btn btn-primary btn-lg fixed-button" data-toggle="modal" data-target="#modal_add">
        <i class="fa fa-plus"></i>
    </button>
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
                </div>
                <div class="form-group">
                    <label for="input_end_hour">Hora de fin</label>
                    <input id="input_end_hour" type="time" name="input_end_hour" class="form-control @error('input_end_hour') is-invalid @enderror" 
                        placeholder="Ingresa el lugar donde harás la actividad"
                        value="{{old('input_end_hour')}}">
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