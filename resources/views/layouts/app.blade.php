<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @php use Illuminate\Support\Facades\Auth; @endphp
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>
        @yield('title') | Toki
    </title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{ asset('js/aux_functions.js') }}"></script>
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"
			integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
		    crossorigin="anonymous">
    </script>    
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
     
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">
                        @guest
                        @else
                        
                        <img src="/toki.png" width=10% height=10%>
                        
                        <li class="nav-item my-auto">
                            <form method="GET" action="{{route('search')}}">
                                <input type="text" placeholder="Buscar..." name="search_query">
                                <button type="submit" class="btn btn-secondary">
                                    <i class="fa fa-search"></i>
                                </button>
                            </form>
                        </li>
                        @endguest
                    </ul>
                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Ingresar') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Registrarse') }}</a>
                                </li>
                            @endif
                        @else            
                            <li class="nav-item">
                                <a class="nav-link {{ Route::currentRouteName() == 'deadlines' ? 'active' : ''}}" href="{{ route('deadlines') }}">Tareas</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ Route::currentRouteName() == 'subjects' ? 'active' : ''}}" href="{{ route('subjects') }}">Asignaturas</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ Route::currentRouteName() == 'routine' ? 'active' : ''}}" href="{{ route('routine', ['day' => 'monday']) }}">Rutina</a>
                            </li>           
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    <img class="rounded-circle" src="/storage/avatars/{{Auth::user()->profile_picture}}" width="30" height="30" alt="{{ Auth::user()->name}}">
                                </a>
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a href="{{ route('profile', Auth::id()) }}" class="dropdown-item">Usuario: <b>{{Auth::user()->username}}</b></a>
                                    <div class="dropdown-divider"></div>
                                    <a href="{{ route('schedule') }}" class="dropdown-item">Horario</a>
                                    <a href="{{ route('deadlines') }}" class="dropdown-item">Tareas</a>
                                    <a href="{{ route('routine', ['day'=>'monday']) }}" class="dropdown-item">Rutina</a>
                                    <a href="{{ route('user_room') }}" class="dropdown-item">Disponibilidad de salas</a>
                                    <a href="{{ route('subjects') }}" class="dropdown-item">Asignaturas</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="{{ route('user') }}">
                                        {{ __('Configuración de perfil') }}                                      
                                    </a>
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout_form').submit();">
                                        {{ __('Cerrar sesión') }}
                                    </a>
                                    <form id="logout_form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
</body>
</html>
