@extends('layouts.app')

@section('title')
    Cambiar contraseña
@endsection

@section('content')
<div class="container justify-content-center">
    <div class="card mx-auto w-75">
        <div class="card-header">
            <span class="text-white">{{__('Cambiar contraseña')}}</span>
        </div>
        <div class="card-body">
            @if($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
            <form method="post" action="{{route('user.update_password')}}">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="current_password">{{__('Contraseña actual')}}</label>
                    <input type="password" name="current_password" class="form-control" placeholder="Ingresa tu contraseña actual">
                </div>
                <div class="form-group">
                    <label for="new_password">{{__('Contraseña nueva')}}</label>
                    <input type="password" name="new_password" class="form-control" placeholder="Ingresa tu contraseña nueva">
                </div>
                <div class="form-group">
                    <label for="confirm_password">{{__('Confirmar contraseña nueva')}}</label>
                    <input type="password" name="confirm_password" class="form-control" placeholder="Confirma tu contraseña nueva">
                </div>
                <input type="submit" class="btn btn-primary" value="Actualizar">
            </form>
        </div>
    </div>
</div>
@endsection