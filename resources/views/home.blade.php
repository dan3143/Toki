@extends('layouts.app')

@section('title')
    Home
@endsection

@section('content')

<div class="flex-center">
        <h7>"It’s really clear that the most precious resource<br> we all have is TIME  ." - Jobs</h7>
       
</div>
<style>
   
    body{
        background-image: url("unin.png");
        
    }
    contenido{
        margin-left: auto;
        padding: 50vh 0;
    }
    .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
                text-align: center;
                padding-top: 25vh;
                
            }
    h7{
        color: white;
        font-size: 45px;
        font-style: italic;
    }
    h8{
        font size: 20px;
        color: white;
    }
    </style>
@endsection
