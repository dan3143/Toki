@extends('layouts.app')
@section('content')
<div class="container justify-content-center">
    <div class="card mx-auto w-75">
        <div class="card-header">
            <span class="align-self-center">Ingresar una asignatura</span>
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
            <form method="post" action="{{ route('subjects.store') }}">
                @csrf
                <div class="form-group">
                    <label for="input_subject_name">Nombre</label>
                    <input type="text" name="input_subject_name" class="form-control @error('input_subject_name') is-invalid @enderror" 
                        placeholder="Ingresa el nombre de la asignatura"
                        value="{{old('input_subject_name')}}">
                    @error('input_subject_name')
                    <small class="text-danger">Campo requerido</small>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="input_date">Ingresa el nombre del profesor (o profesores)</label>
                    <input type="text" name="input_teacher_name" class="form-control"
                        placeholder="Ingresa el nombre del profesor"
                        value="{{old('input_teacher_name')}}">
                </div>

                <div class="form-group">
                    <label for="input_max_absences">Ingresa el número de fallas máximas</label>
                    <input name="input_max_absences" type="number" class="form-control" value="{{ old('input_max_absences') }}"
                        placeholder="Ingresa el máximo de fallas que puedes tener">
                </div>
                <div class="form-group">
                    <input type="submit" class="btn btn-primary" value="Crear">
                    <a class="text-danger" style="margin-left: 15px;font-size:15px;" href="{{route('subjects')}}">Cancelar</a>
                </div>
            </form>

        </div>
        
    </div>
</div>
@endsection