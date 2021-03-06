<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="Unete al rescate y proteccion animal">
        <meta name="author" content="Veterinaria Dobaltoff">
        <meta name="keyword" content="Veterinaria Dobaltoff rescate animal">
        <link rel="shortcut icon" href="img/unnamed.jpg">

        <title>Veterinaria Dobaltoff</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <!-- Styles -->
        <style>
            html, body {
                color: #636b6f;
                font-weight: 200;
                height: 100vh;
                margin: 0;
                font-family: Arial, sans-serif;
              /*  font-size: 12px;*/
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
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 13px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }
        </style>

    <link href="{{url('css/app.css')}}" rel="stylesheet">
    <link href="{{url('css/plantilla.css')}}" rel="stylesheet">

  

    <body class="app header-fixed sidebar-fixed aside-menu-fixed aside-menu-hidden">
    
    <div id="app">  
        <header class="app-header navbar">

            <button class="navbar-toggler sidebar-toggler d-md-down-none" type="button">
              <!--   <div style="padding-left: 10px;">
                    <a href="{{ url('/') }}">
                    <span class="logo-mini"><i > Veterinaria Dobaltoff</i></span>
                </div> -->

                <span class="navbar-toggler-icon"></span>
                <a href="{{ url('/') }}">
                <span class="logo-mini"><i> Veterinaria Dobaltoff</i></span>
            </a>
            </button>
           

            <a class="navbar-brand" href="#"></a>
            <button class="navbar-toggler mobile-sidebar-toggler d-lg-none mr-auto" type="button">
                <span class="navbar-toggler-icon"></span>
            </button>

            @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                     <!--  <a href="{{ url('/home') }}">Home</a>-->
                    @else
                        <a href="{{ route('login') }}">Iniciar Sesión</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}">Registrarse</a>
                        @endif
                    @endauth
                </div>
            @endif
        </header>

        <div class="app-body">    
           @include('sidebarGeneral')    
            <template v-if="menu==0">
                <inicio-general></inicio-general>
            </template>
            <template v-if="menu==1">
                <informacion-general></informacion-general>
            </template>
            <template v-if="menu==2">
                <quienes-somos></quienes-somos>
            </template>
        </div>
    </div> <!--fin div app -->
    

        <!---Desarrollado por Jonathan Guevara Torres 2020--->
        
        <!-- Bootstrap and necessary plugins-->

        <script src="{{url('js/app.js')}}" ></script> 
        <script src="{{url('js/jquery.min.js')}} "></script>
        <script src="{{url('js/plantilla.js')}}" ></script> 
</body>

</html>
