<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Unete al rescate y proteccion animal">
    <meta name="author" content="Veterinaria Dobaltoff">
    <meta name="keyword" content="Veterinaria Dobaltoff rescate animal">
    <link rel="shortcut icon" href="{{url('img/unnamed.jpg')}}">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Veterinaria Dobaltoff</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <link href="{{url('css/app.css')}}" rel="stylesheet">
    <link href="{{url('css/plantilla.css')}}" rel="stylesheet">

    <style>
         html, body {
            background-color: #8AADCD;
            }
            
    </style>

</head>
<body>
    <div id="app">
                
        @yield('content')
      
        </div>
    </div> 

    <script src="{{url('js/app.js')}}" ></script> 
    <script src="{{url('js/jquery.min.js')}} "></script>
    <script src="{{url('js/plantilla.js')}}" ></script> 

</body>

</html>
