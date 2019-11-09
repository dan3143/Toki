@php
use Illuminate\Support\Facades\Auth;
@endphp

@extends('layouts.app')

@section('content')
<div class="container justify-content-center">
    <div class="card mx-auto w-75">
        <div class="card-header">
            <span class="align-self-center">Configuración de usuario</span>
        </div>
        <div class="card-body">
            <div class="row justify-content-center">
                <div class="profile-header-img">
                    <img class="rounded-circle" src="storage/avatars/{{Auth::user()->profile_picture}}" width="200" height="200">
                    <div class="rank-label-container text-center mt-3">
                        <span class="h4">{{Auth::user()->name}}</span>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center my-3">
                <form method="post" enctype="multipart/form-data" action="{{route('settings.picture')}}">
                    @csrf
                    <div class="form-group">
                        <input type="file" class="form-control-file" name="pic">
                        @error('pic')
                            <small class="text-danger">Sube una imagen válida. El tamaño debe ser menor a 2MB</small>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary">Subir</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
