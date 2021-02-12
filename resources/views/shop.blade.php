<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{config('app.name', 'Laravel')}}</title>

    <link rel="preconnect" href="https://fonts.gstatic.com">

    <link href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro:wght@200;400;600&display=swap" rel="stylesheet">
    <link type="text/css" rel="stylesheet" href="/assets/admin/fonts/feather/css/feather.css">
    <link type="text/css" rel="stylesheet" href="/assets/css/bootstrap.min.css">
    <link type="text/css" rel="stylesheet" href="/assets/css/font-awesome.min.css">
    <link type="text/css" rel="stylesheet" href="/assets/css/elegant-icons.css">
    <link type="text/css" rel="stylesheet" href="/assets/css/jquery-ui.min.css">
    <link type="text/css" rel="stylesheet" href="/assets/css/magnific-popup.css">
    <link type="text/css" rel="stylesheet" href="/assets/css/owl.carousel.min.css">
    <link type="text/css" rel="stylesheet" href="/assets/css/slicknav.min.css">
    <link type="text/css" rel="stylesheet" href="/assets/css/style.css">

    <link rel="stylesheet" href="{{mix('css/app.css')}}">

    @routes
  </head>
  <body class="font-sans antialiased">
    @inertia
    <script src="/assets/js/jquery-3.5.1.min.js"></script>
    <script src="/assets/js/bootstrap.min.js"></script>
    <script src="/assets/js/jquery.magnific-popup.min.js"></script>
    <script src="/assets/js/jquery-ui.min.js"></script>
    <script src="/assets/js/mixitup.min.js"></script>
    <script src="/assets/js/jquery.countdown.min.js"></script>
    <script src="/assets/js/jquery.slicknav.js"></script>
    <script src="/assets/js/owl.carousel.min.js"></script>
    <script src="/assets/js/jquery.nicescroll.min.js"></script>
    <script src="{{mix('js/app.js')}}" defer></script>
  </body>
</html>
