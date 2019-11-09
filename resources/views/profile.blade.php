@php
use Illuminate\Support\Facades\Auth;
$user = Auth::user();
@endphp

@extends('layouts.app')

@section('title')
    Perfil
@endsection

@section('content')
<div class="container justify-content-center">
    <div class="card mx-auto w-75">
        <div class="card-header">
            <span class="align-self-center">Perfil de usuario</span>
        </div>
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form method="post" enctype="multipart/form-data" action="{{route('profile.update')}}">
                @csrf

                <div class="row justify-content-center">
                    <div class="profile-header-img">
                        <img class="rounded-circle" src="storage/avatars/{{$user->profile_picture}}" width="200" height="200">
                        <div class="rank-label-container text-center mt-3">
                            <span class="h4">{{$user->name}}</span>
                        </div>
                    </div>
                </div>

                <div class="row justify-content-center mt-3 mb-5">
                    <div class="custom-file col-5">
                        <input type="file" name="pic">
                        @error('pic')
                            <small class="text-danger">Sube una imagen válida. El tamaño debe ser menor a 2MB</small>
                        @enderror
                    </div>
                </div>

                <hr width="70%">

                <div class="row justify-content-center mt-5 form-group">
                    <div class="col-2 my-auto text-right">Usuario:</div>
                    <div class="col-4"><input type="text" class="form-control-plaintext" value="{{Auth::id()}}"></div>
                </div>

                <div class="row justify-content-center my-3 form-group">
                    <div class="col-2 my-auto text-right">Nombre:</div>
                    <div class="col-4"><input name="name" type="text" class="form-control" value="{{$user->name}}"></div>
                </div>

                <div class="row justify-content-center my-3 form-group">
                    <div class="col-2 my-auto text-right">Correo:</div>
                    <div class="col-4"><input name="email" type="email" class="form-control" value="{{$user->email}}"></div>
                </div>

                <div class="row justify-content-center my-3">
                    <div class="col-2 my-auto text-right">Contraseña:</div>
                    <div class="col-4">●●●●●●●●●●●● <a href="{{route('profile.change_password')}}">Cambiar</a></div>
                </div>

                <div class="row justify-content-center my-4">
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Actualizar</button>
                    </div>
                </div>
                <div  class="row justify-content-center my-3">
                    <div class="col-6 text-center">
                        <a href="{{ route('profile.delete') }}" class="text-danger" 
                            onclick="event.preventDefault();submit()">
                            Eliminar cuenta
                        </a>
                    </div> 
                </div>
            </form>
        </div>
    </div>
</div>

<form id="delete-form" action="{{ route('profile.delete') }}" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>

<script>
    $(function(){
        $(".custom-file-input").hide();        
        $(".custom-file-input").on("change", function() {
            var fileName = $(this).val().split("\\").pop();
            $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
        });
    });
    
    function submit(){
        document.getElementById('delete-form').submit();
    }

</script>
@endsection
