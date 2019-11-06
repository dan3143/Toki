@extends('layouts.app')
@section('content')

<div class="container">
    <nav aria-label="Days"  >
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
</div>

<script>
    function deleteCard(id){
         if (confirm("¿De verdad quieres eliminar esta actividad?")){
            $.ajax({
                url: id+"/delete",
                method:"DELETE",
                headers: {'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')},
                success: function(result){
                    $("#card-"+id).remove();
                },
                error: function(xhr){
                    console.log("Ocurrió un error:  " + xhr.status);
                }
            });
        }
        
    }
</script>
@endsection