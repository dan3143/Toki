<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Toki - Maneja tu tiempo</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <!-- Styles -->
        <style>
            body {
                background-image: url('unin.png');
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
            }

            .subtitle{
                background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-size: 20px;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                padding: 20vh 0;
                padding-left: 1vh;
                padding-right: 5vh;
                text-align: center;
                
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: white;
                padding: 0 25px;
                font-size: 13px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
            @-webkit-keyframes fadeIn {
                from {
                    opacity: 0;
                }

                to {
                    opacity: 1;
                }
            }

            @-moz-keyframes fadeIn {
                from {
                    opacity: 0;
                }

                to {
                    opacity: 1;
                }
            }

            @keyframes fadeIn {
                from {
                    opacity: 0;
                }

                to {
                    opacity: 1;
                }
            }

            .fade-in {
                opacity: 0;
                /* make things invisible upon start */
                -webkit-animation: fadeIn ease-in 1;
                /* call our keyframe named fadeIn, use animattion ease-in and repeat it only 1 time */
                -moz-animation: fadeIn ease-in 1;
                animation: fadeIn ease-in 1;

                -webkit-animation-fill-mode: forwards;
                /* this makes sure that after animation is done we remain at the last keyframe value (opacity: 1)*/
                -moz-animation-fill-mode: forwards;
                animation-fill-mode: forwards;

                -webkit-animation-duration: 1s;
                -moz-animation-duration: 1s;
                animation-duration: 1s;
            }

            .fade-in.one {
                -webkit-animation-delay: 0.3s;
                -moz-animation-delay: 0.3s;
                animation-delay: 0.3s;
            }
            .dot2::after {
                z-index: -1;
                opacity: 0;
                display: flex;
                flex-direction: row;
                justify-content: center;
                align-items: center;
                position: absolute;
                top: -8px;
                left: -8px;
                right: 0;
                bottom: 0;
                content: '';
                height: 100%;
                width: 100%;
                border: 8px solid rgba(0, 0, 0, 0.2);
                border-radius: 200px 12px 200px 12px;
                animation-name: ripple;
                animation-duration: 3s;
                animation-delay: 0s;
                animation-iteration-count: infinite;
                animation-timing-function: cubic-bezier(0.65, 0, 0.34, 1);
                
            }
            .dot2::before {
                z-index: -1;
                opacity: 0;
                display: flex;
                flex-direction: row;
                justify-content: center;
                align-items: center;
                position: absolute;
                top: -8px;
                left: -8px;
                right: 0;
                bottom: 0;
                content: '';
                height: 100%;
                width: 100%;
                border: 8px solid rgba(0, 0, 0, 0.2);
                border-radius: 200px 12px 200px 12px;
                animation-name: ripple;
                animation-duration: 3s;
                animation-delay: 0.5s;
                animation-iteration-count: infinite;
                animation-timing-function: cubic-bezier(0.65, 0, 0.34, 1);
                
            }
            @keyframes ripple {
                from {
                    opacity: 1;
                    transform: scale3d(0.75, 0.75, 1);
                    z-index: -1;
                }

                to {
                    opacity: 0;
                    transform: scale3d(1.5, 1.5, 1);
                    z-index:-1;
                }
            }
        

            .dot {
                
                z-index: 1;
                height: 400px;
                width: 400px;
                background-color: white;
                border-radius: 200px 12px 200px 12px;
                filter: drop-shadow(0 0 0.75rem black);
                display: block;
                
                
            }
            .dot2 {
                
                z-index: -1;
                height: 400px;
                width: 400px;
                background-color: white;
                border-radius: 200px 12px 200px 12px;
                filter: drop-shadow(0 0 0.75rem rgba(0,0,0,0.5));
                display: block;
                
                
            }
            

        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                        <a href="{{ url('/home') }}">Home</a>
                    @else
                        <a href="{{ route('login') }}">Login</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}">Register</a>
                        @endif
                    @endauth
                </div>
            @endif

            <div class="dot2">
                <div class="dot">
                    <div class="content fade-in one">
                        <img src="{{asset('toki.png')}}" alt="Toki" width="100%" height="100%">
                    </div>
                 </div>
             </div>
         </div>
     </body>
 </html>
