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
                background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
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

        <style>
            body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }
        </style>

    <link href="css/font-awesome.min.css" rel="stylesheet">
    <link href="css/simple-line-icons.min.css" rel="stylesheet">
    <!-- Main styles for this application -->
    <link href="css/style.css" rel="stylesheet">


    </head>

    <body class="app header-fixed sidebar-fixed aside-menu-fixed aside-menu-hidden">
    
    <div id="app">  
        <header class="app-header navbar">

            <button class="navbar-toggler sidebar-toggler d-md-down-none" type="button">
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
            <h1>Informacionmmnnnnnnnnnnnnnnnnn</h1>
            </template>
            <template v-if="menu==1">
                <h1>Informacionmmnnnnnnnnnnnnnnnnn</h1>
            </template>
            <template v-if="menu==2">
                <visualizar-donaciones></visualizar-donaciones>
            </template>
            <template v-if="menu==3">
                <quienes-somos></quienes-somos>
            </template>
        </div>
    </div> <!---fin div app --->

   
        <!---Desarrollado por Jonathan Guevara 2020--->
        
        <!-- Bootstrap and necessary plugins-->
        <script src="js/app.js"></script> 

        <script src="js/jquery.min.js"></script>
        <script src="js/popper.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="js/pace.min.js"></script>
        <script src="js/Chart.min.js"></script>
        <script src="js/template.js"></script> 
        <script src="js/sweetalert2.all.js"></script> 
        
</body>

</html>
