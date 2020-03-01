<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Unete al rescate y proteccion animal">
    <meta name="author" content="Veterinaria Dobaltoff">
    <meta name="keyword" content="Veterinaria Dobaltoff rescate animal">
    <link rel="shortcut icon" href="img/unnamed.jpg">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Veterinaria Dobaltoff</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <link href="{{url('css/app.css')}}" rel="stylesheet">
    <link href="{{url('css/plantilla.css')}}" rel="stylesheet">

</head>
<body class="app header-fixed sidebar-fixed aside-menu-fixed aside-menu-hidden">
    <div id="app">

    <header class="app-header navbar">
       
            <!-- Authentication Links -->
            @guest
             <!-- Right Side Of Navbar -->
          <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                </li>
                @if (Route::has('register'))
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                    </li>
                @endif
            @else

            <button class="navbar-toggler sidebar-toggler d-md-down-none" type="button">
            <span class="navbar-toggler-icon"></span>
            <a href="{{ url('/home') }}">
            <span class="logo-mini"><i> Veterinaria Dobaltoff</i></span>
        </a>
        </button>


        <!--<a class="navbar-brand" href="#"></a>-->
        <button class="navbar-toggler mobile-sidebar-toggler d-lg-none mr-auto" type="button">
            <span class="navbar-toggler-icon"></span>
        </button>

          <!-- Right Side Of Navbar -->
          <ul class="nav navbar-nav ml-auto">

        
                <li class="nav-item dropdown">
                  <!--  <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                        {{ Auth::user()->name }} <span class="caret"></span>
                    </a>-->

                    <a  class="nav-link dropdown-toggle nav-link" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                        <img src="img/avatars/user.png" class="img-avatar" alt="user">
                        Hola, {{  Auth::user()->name }} <span class="caret"></span>
                    </a>

                    <div class="dropdown-menu dropdown-menu-right">
                        <div class="dropdown-header text-center">
                            <strong>Cuenta</strong>
                        </div>
                        <a class="dropdown-item" href="{{ route('logout') }}" 
															
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="fa fa-lock"></i> Cerrar sesión</a>
							

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </div>
                </li>
            @endguest
        </ul>
    </header>

        @yield('content')
      
        </div>
    </div> 
       
        <script src="{{url('js/jquery.min.js')}} "></script>
        <script src="{{url('js/app.js')}}" ></script> 
        <script src="{{url('js/plantilla.js')}}" ></script> 
       
</body>

</html>
