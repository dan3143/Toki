@extends('layouts.app')
@section('content')
<div class="container justify-content-center">
    <div class="card mx-auto w-75">
        <div class="card-header">
            <span class="align-self-center">Editar una tarea</span>
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
            <form method="POST" action="{{ route('deadlines.update', $deadline->id) }}">
                @method('put')
                @csrf
                <div class="form-group">
                    <label for="input_deadline_name">Nombre</label>
                    <input type="text" name="input_deadline_name" class="form-control @error('input_deadline_name') is-invalid @enderror" 
                        placeholder="Ingresa una breve descripción de la tarea"
                        value="{{$deadline->name}}">
                    @error('input_deadline_name')
                    <small class="text-danger">Campo requerido</small>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="input_date">Ingresa la fecha límite</label>
                    <input type="date" name="input_date" class="form-control @error('input_date') is-invalid @enderror"
                        value="{{$deadline->end_date}}">
                    <script type="text/javascript" src="../minDate.js"></script>
                    @error('input_date')
                    <small class="text-danger">Campo requerido</small>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="input_time">Ingresa la hora límite</label>
                    <input type="time" name="input_time" class="form-control @error('input_time') is-invalid @enderror"
                        value="{{$deadline->end_hour}}">
                    @error('input_time')
                    <small class="text-danger">Campo requerido</small>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="input_subject">Asignatura</label>
                    <select class="form-control @error('input_subject') is-invalid @enderror" name="input_subject">
                        @foreach ($subjects as $subject)
                        <option {{$subject->id == $deadline->subjectId ? 'selected' : ''}} value="{{$subject->id}}">{{$subject->name}}</option>
                        @endforeach        
                    </select>
                    @error('input_subject')
                   <small class="text-danger">Campo requerido</small>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="input_priority">Prioridad</label>
                    <select class="form-control @error('input_priority') is-invalid @enderror" name="input_priority">
                        <option {{$deadline->priority == 'high' ? 'selected' : ''}} value="high">Alta</option>
                        <option {{$deadline->priority == 'medium' ? 'selected' : ''}} value="medium">Media</option>
                        <option {{$deadline->priority == 'low' ? 'selected' : ''}} value="low">Baja</option>
                    </select>
                    @error('input_priority')
                    <small class="text-danger">Campo requerido</small>
                    @enderror
                </div>
                <div class="form-group">
                    <input type="submit" class="btn btn-primary" value="Actualizar">
                    <a class="text-danger" style="margin-left: 15px;font-size:15px;" href="{{route('deadlines')}}">Cancelar</a>
                </div>
            </form>

        </div>
        
    </div>
</div>
@endsection