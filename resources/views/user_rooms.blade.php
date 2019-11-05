@extends('layouts.app')
@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            <span class="align-self-center">Salas de Usuario</span>
        </div>
        <div class="card-body">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th style="text-align:center;">Nombre</th>
                        <th style="text-align:center;">Locación</th>
                        <th style="text-align:center;">Estado</th>
                        <th style="text-align:center;">Ocupación</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($useroom as $user_room)
                @php $isNotAvailable = $user_room->is_available == 0 || $user_room->isFull() @endphp
                <tr class="text-center" id="row-{{$user_room->id}}">   
                    <td> {{$user_room->name}}</td>
                    <td> {{$user_room->location}}</td>                    
                    <td class="@if($isNotAvailable) text-danger  @else text-success @endif"> {{!$isNotAvailable ? "Disponible" : "Ocupada"}}</td>
                    <td> {{$user_room->current_capacity}} / {{$user_room->max_capacity}} </td>
                </tr>
                @endforeach
                </tbody>  
            </table>
        </div>
    </div>
</div>

@endsection