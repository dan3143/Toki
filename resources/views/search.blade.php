@extends('layouts.app')

@section('title')
    Resultados de búsqueda
@endsection

@section('content')
<div class="container ">
    <h1 class="text-center mb-5">Resultados para "{{$query}}"</h1>
    @if(sizeof($results) === 0)
    <p style="margin:auto;text-align:center;">No se encontró ningún usuario</p>
    @else
    <ul class="list-group mx-auto" style="width:350px;">
        @foreach($results as $result) 
        <li class="list-group-item">
            <div class="row">
                <div class="col"><img class="rounded-circle" width="35" src="/storage/avatars/{{$result->profile_picture}}"></div>
                <div class="col text-center">{{$result->username}}</div>
                <div class="col text-center">
                    <a class="btn btn-outline-info" href="{{route('profile', $result->username)}}"><i class="fa fa-info-circle"></i></a>
                </div>
            </div>     
        </li>
        @endforeach
    </ul>
    @endif
</div>
@endsection