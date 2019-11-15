@extends('layouts.app')

@section('title')
    Crear post
@endsection 

@section('content')
<div class="container">
    @if($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    <h2>Crear un post</h2>
    <form method="post" action="{{ route('posts.store') }}" id="form" onsubmit="return getContent()">
        @csrf
        <div class="form-group">
            <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" 
                placeholder="Título del post"
                value="{{old('title')}}">
            @error('title')
            <small class="text-danger">Campo requerido</small>
            @enderror
        </div>
        <div contenteditable id="textarea-div"></div>
        <textarea name="content" hidden id="textarea"></textarea>
        <input type="submit" class="btn btn-primary mt-3 float-right">
    </form>
    <script>
        function getContent(){
            var div_val = document.getElementById('textarea-div').innerHTML;
            document.getElementById('textarea').value = div_val;
        }
    </script>
</div>
    
@endsection