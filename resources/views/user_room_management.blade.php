@extends('layouts.app')

@section('title')
    Administrar sala de usuarios
@endsection

@section('content')
<div class="container justify-content-center">
    
    <div class="card mx-auto" style="width: 35rem;">
        <div class="card-header">
            <a class="btn btn-sm btn-outline-light" href="{{route('user_room')}}">
                <i class="fa fa-chevron-left"></i>
            </a>
            <span class="align-self-center">&nbsp;Computadores disponibles</span>
            <button type="button" id="add_pc" class="btn btn-sm btn-primary float-right">
                Agregar computador
            </button>
        </div>
        <div class="card-body">
            <table class="table table-hover" id="table">
                <thead>
                    <tr>
                        <th style="text-align:center;">Disponible</th>
                        <th style="text-align:center;">ID</th>
                        <th style="text-align:center;">Acción</th>
                    </tr>
                </thead>
                <tbody>
                @foreach ($pcs as $pc)
                    <tr id="row-{{$pc->id}}">
                        <td style="text-align:center;">
                            <button id="status-{{$pc->id}}" onclick="changeStatus({{$pc->id}})" class="btn btn-sm {{$pc->is_available ? 'text-success':'text-danger'}}">
                                <i class="fa fa-square"></i>
                            </button>
                        </td>
                        <td style="text-align:center;">{{$pc->id}}</td>
                        <td style="text-align:center;">
                            <button onclick="deletePC({{$pc->id}})" class="btn btn-sm btn-outline-danger" type="button">
                                <i class="fa fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                @endforeach
                </tbody>  
            </table>
        </div>
    </div>
</div>

<script>

    function changeStatus(id){
        $.ajax({
            url: "/user_room_management/"+id+"/change_status",
            method:"PUT",
            headers: {'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')},
            success: function(result){
                if (result=="1"){
                    $("#status-"+id).removeClass('text-danger');
                    $("#status-"+id).addClass('text-success');
                }else{
                    $("#status-"+id).removeClass('text-success');
                    $("#status-"+id).addClass('text-danger');
                }
            },
            error: function(xhr){
                console.log("Ocurrió un error:  " + xhr.responseText);
            }
        });
    }

    function deletePC(id){
        $.ajax({
            url: "/user_room_management/delete/"+id,
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

    $(document).ready(function(){
        $("#add_pc").click(function(){
            $.ajax({
                url: "{{route('user_room_management.add_computer', $id)}}",
                method:"POST",
                headers: {'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')},
                success: function(result){
                    $("#table > tbody:last-child").append(`
                        <tr id="row-`+result+`">
                            <td style="text-align:center;">
                                <button id="status-`+result+`" onclick="changeStatus(`+result+`)" class="btn btn-sm text-success">
                                    <i class="fa fa-square"></i>
                                </button>
                            </td>
                            <td style="text-align:center;">`+result+`</td>
                            <td style="text-align:center;">
                                <button onclick="deletePC(`+result+`)" class="btn btn-sm btn-outline-danger" type="button">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </td>
                        </tr>`);
                },
                error: function(xhr){
                    console.log("Ocurrió un error:  " + xhr.responseText);
                }
            });
        });
    });
</script>
@endsection
