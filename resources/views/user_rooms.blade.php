@extends('layouts.app')

@section('title')
    Salas de Usuario
@endsection

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            <span class="align-self-center">Salas de Usuario</span>
            @if(Auth::user()->isAdmin())
            <button type="button" id="add_room" class="btn btn-sm btn-primary float-right" data-toggle="modal" data-target="#modal_add">
                Agregar sala
            </button>
            @endif
        </div>
        <div class="card-body">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th style="text-align:center;">Nombre</th>
                        <th style="text-align:center;">Locación</th>
                        <th style="text-align:center;">Estado</th>
                        <th style="text-align:center;">Equipos disponibles</th>
                        @if(Auth::user()->isAdmin())
                        <th style="text-align:center;">Acciones</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                @foreach($useroom as $user_room)
                <tr class="text-center" id="row-{{$user_room->id}}">   
                    <td> {{$user_room->name}}</td>
                    <td> {{$user_room->location}}</td>                    
                    <td class="@if($user_room->is_available == 0 || $user_room->isFull()) text-danger  @else text-success @endif"> 
                        
                        {{$user_room->is_available == 0 ? "Ocupada" : ($user_room->isFull() ? "Llena":"Disponible")}}

                        @if(Auth::user()->isAdmin() && !$user_room->isFull())
                            @if($user_room->is_available == 1)
                                <button id="change_status" onclick="event.preventDefault();document.getElementById('change_form').submit();"
                                class="btn btn-sm btn-outline-danger" type="button">
                                    Bloquear
                                </button>
                            @else
                                <button id="change_status" onclick="event.preventDefault();document.getElementById('change_form').submit();" 
                                    class="btn btn-sm btn-outline-success" type="button">
                                    Liberar
                                </button>
                            @endif
                            <form id="change_form"  style="display: none;" method="post" action="{{route('user_room.change_status', $user_room->id)}}">
                                @csrf
                                @method('PUT')
                            </form>
                        @endif
                    </td>
                    <td> {{$user_room->current_capacity}}/{{$user_room->max_capacity}}</td>
                    @if(Auth::user()->isAdmin())
                    <td>
                        <button onclick="deleteUserRoom({{$user_room->id}})" class="btn btn-sm btn-outline-danger" type="button">
                            <i class="fa fa-trash"></i>
                        </button>
                        <a class="edit_link btn btn-sm btn-outline-secondary" data-toggle="modal" href="#modal_edit"
                            data-id="{{$user_room->id}}"
                            data-name="{{$user_room->name}}"
                            data-place="{{$user_room->location}}">
                            <i class="fa fa-pen"></i>
                        </a>
                        <a href="{{route('user_room_management', $user_room->id)}}" class="btn btn-sm btn-outline-secondary">
                            <i class="fa fa-desktop"></i>
                        </a>
                    </td>
                    @endif
                </tr>
                @endforeach
                </tbody>  
            </table>
        </div>
    </div>
</div>

@if(Auth::user()->isAdmin())
<div class="modal fade" id="modal_add" tabindex="-1" role="dialog" aria-labelledby="addModal" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Agregar Sala</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <form method="post" action="{{ route('user_room.store') }}" id="form" onsubmit="disableSubmit()">
            @csrf
            <div class="modal-body">
                <div class="form-group">
                    <label for="input_name">Nombre</label>
                    <input type="text" name="input_name" class="form-control @error('input_name') is-invalid @enderror" 
                        placeholder="Ingrese el nombre de la sala"
                        value="{{old('input_name')}}">
                    @error('input_name')
                    <small class="text-danger">Campo requerido</small>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="input_place">Lugar</label>
                    <input id="input_place" type="text" name="input_place" class="form-control @error('input_place') is-invalid @enderror" 
                        placeholder="Ingrese el lugar donde se encuentra la sala"
                        value="{{old('input_place')}}">
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
            <h5 class="modal-title">Editar sala de usuario</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <form method="post" action="{{ route('user_room.update') }}" id="form" onsubmit="disableSubmit()">
            @csrf
            @method('PUT')
            <div class="modal-body" id="modal_edit_body">
                <input hidden type="number" name="id" id="id" value="">
                <div class="form-group">
                    <label for="input_name">Nombre</label>
                    <input type="text" id="input_name" name="input_name" class="form-control @error('input_name') is-invalid @enderror" 
                        placeholder="Ingresa el nombre de la sala"
                        value="">
                    @error('input_name')
                    <small class="text-danger">Campo requerido</small>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="input_place">Lugar</label>
                    <input type="text" id="input_place" name="input_place" class="form-control @error('input_place') is-invalid @enderror" 
                        placeholder="Ingresa el lugar donde se encuentra la sala"
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
    function deleteUserRoom(id){
        if (confirm('¿Desea eliminar esta sala?')){
            $.ajax({
                url: "/user_room/"+id,
                method:"DELETE",
                headers: {'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')},
                success: function(result){
                    $("#row-"+id).remove();
                },
                error: function(xhr){
                    console.log("Ocurrió un error:  " + xhr);
                }
            });
        }
    }
    $(document).on("click", ".edit_link", function(){
        var id = $(this).data('id');
        var name = $(this).data('name');
        var place = $(this).data('place');
        $("#modal_edit_body #id").val(id);
        $("#modal_edit_body #input_name").val(name);
        $("#modal_edit_body #input_place").val(place);
    });
</script>
@endif

@endsection