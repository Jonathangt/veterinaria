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

    <!-- Scripts-->
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

 
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
       <!-- Styles-->
    <link href="{{ asset('css/font-awesome.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/simple-line-icons.min.css') }}" rel="stylesheet">

    <link href="{{ asset('css/style.css') }}" rel="stylesheet">


    <style>
         html, body {
            background-color: #E4E6FD;
            }
            
    </style>

</head>
<body >
    <div id="app">

        @yield('content')
      
        </div>
    </div> 


        <script src="../js/jquery.min.js"></script>
        <script src="../js/app.js" ></script> 
        <script src="../js/popper.min.js"></script>
        <script src="../js/bootstrap.min.js"></script>
        <script src="../js/pace.min.js"></script>
        <script src="../js/Chart.min.js"></script>
        <script src="../js/template.js"></script>
        <script src="../js/sweetalert2.all.js"></script> 

</body>

</html>
