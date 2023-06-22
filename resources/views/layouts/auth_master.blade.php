<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags-->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="keywords" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Title Page-->
    <title> @yield('title') </title>

    <!-- Icons font CSS-->
    <link href="vendor/mdi-font/css/material-design-iconic-font.min.css" rel="stylesheet" media="all">
    <link href="vendor/font-awesome-4.7/css/font-awesome.min.css" rel="stylesheet" media="all">
    <!-- Font special for pages-->
    <link href="https://fonts.googleapis.com/css?family=Poppins:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Vendor CSS-->
    <link href="{{url('/vendor/select2/select2.min.css')}}" rel="stylesheet" media="all">
    <link href="{{url('/vendor/datepicker/daterangepicker.css')}}" rel="stylesheet" media="all">

    <!-- Main CSS-->
    <link href="{{url('/css/main.css')}}" rel="stylesheet" media="all">

    @yield('head')
</head>

<body>


    @yield('content')


    <script src="{{url('/vendor/jquery/jquery.min.js')}}"></script>
    <script src="{{url('/vendor/select2/select2.min.js')}}"></script>
    <script src="{{url('/vendor/datepicker/moment.min.js')}}"></script>
    <script src="{{url('/vendor/datepicker/daterangepicker.js')}}"></script>
    <script src="{{url('/js/global.js')}}"></script>
</body>

</html>
