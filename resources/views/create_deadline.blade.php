@extends('layouts.app')
@section('content')
<div class="container justify-content-center">
    <div class="card mx-auto" style="width: 50rem;">
        <div class="card-header">
            <span class="align-self-center">Crear una tarea</span>
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
            <form method="post" action="{{ route('deadlines.store') }}">
                @csrf
                <div class="form-group">
                    <label for="input_deadline_name">Nombre</label>
                    <input type="text" name="input_deadline_name" class="form-control @error('input_deadline_name') is-invalid @enderror" 
                        placeholder="Ingresa una breve descripción de la tarea"
                        value="{{old('input_deadline_name')}}">
                    @error('input_deadline_name')
                    <small class="text-danger">Campo requerido</small>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="input_date">Ingresa la fecha límite</label>
                    <input type="date" name="input_date" class="form-control @error('input_date') is-invalid @enderror"
                        value="{{old('input_date')}}">
                    <script type="text/javascript" src="../minDate.js"></script>
                    @error('input_date')
                    <small class="text-danger">Campo requerido</small>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="input_time">Ingresa la hora límite</label>
                    <input type="time" name="input_time" class="form-control @error('input_time') is-invalid @enderror"
                        value="{{old('input_time')}}">
                    @error('input_time')
                    <small class="text-danger">Campo requerido</small>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="input_subject">Asignatura</label>
                    <select class="form-control @error('input_subject') is-invalid @enderror" name="input_subject">
                        <option selected disabled hidden>Elije una asignatura</option>
                        @foreach ($subjects as $subject)
                        <option value="{{$subject->id}}">{{$subject->name}}</option>
                        @endforeach        
                    </select>
                    @error('input_subject')
                   <small class="text-danger">Campo requerido</small>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="input_priority">Prioridad</label>
                    <select class="form-control @error('input_priority') is-invalid @enderror" name="input_priority">
                        <option selected disabled hidden>Elije una prioridad</option>
                        <option value="high">Alta</option>
                        <option value="medium">Media</option>
                        <option value="low">Baja</option>
                    </select>
                    @error('input_priority')
                    <small class="text-danger">Campo requerido</small>
                    @enderror
                </div>
                <div class="form-group">
                    <input type="submit" class="btn btn-primary" value="Crear">
                </div>
            </form>

        </div>
        
    </div>
</div>
@endsection