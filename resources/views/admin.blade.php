<?php
$request = request();
$pathinfo = $request->getPathInfo();
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link type="text/css" rel="stylesheet" href="{{url('/assets/admin/fonts/feather/css/feather.css')}}">
    <link type="text/css" rel="stylesheet" href="{{url('/assets/admin/fonts/sourcesanspro/css/sourcesanspro.css')}}">
    <link type="text/css" rel="stylesheet" href="{{url('/assets/admin/css/bootstrap.css')}}">
    <link type="text/css" rel="stylesheet" href="{{url('/assets/admin/css/AdminLTE.css')}}">
    <link type="text/css" rel="stylesheet" href="{{url('/assets/admin/css/skins/skin-blue.min.css')}}">
    <link type="text/css" rel="stylesheet" href="{{url('/assets/admin/css/style.css')}}">
    <link type="text/css" rel="stylesheet" href="{{ mix('/css/app.css') }}" rel="stylesheet">

    <script src="{{url('/assets/admin/js/jquery.min.js')}}"></script>
    <script src="{{url('/assets/admin/js/bootstrap.min.js')}}"></script>
    <script src="{{mix('/js/app.js')}}" defer></script>

    @routes
</head>
  <body class="skin-blue">
    @inertia
  </body>
</html>
