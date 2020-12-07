<?php
$request = request();
$pathinfo = $request->getPathInfo();
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link type="text/css" rel="stylesheet" href="/assets/admin/fonts/feather/css/feather.css">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro:wght@200;300;400;600&display=swap" rel="stylesheet">
    <link type="text/css" rel="stylesheet" href="/assets/css/bootstrap.min.css">
    <link type="text/css" rel="stylesheet" href="/assets/css/font-awesome.min.css">
    <link type="text/css" rel="stylesheet" href="/assets/css/elegant-icons.css">
    <link type="text/css" rel="stylesheet" href="/assets/css/jquery-ui.min.css">
    <link type="text/css" rel="stylesheet" href="/assets/css/magnific-popup.css">
    <link type="text/css" rel="stylesheet" href="/assets/css/owl.carousel.min.css">
    <link type="text/css" rel="stylesheet" href="/assets/css/slicknav.min.css">
    <link type="text/css" rel="stylesheet" href="/assets/css/style.css">

    <link href="{{ mix('/css/app.css') }}" rel="stylesheet">

    {{-- Inertia --}}
    <script src="https://polyfill.io/v3/polyfill.min.js?features=smoothscroll,NodeList.prototype.forEach,Promise,Object.values,Object.assign" defer></script>

    {{-- Ping CRM --}}
    <script src="https://polyfill.io/v3/polyfill.min.js?features=String.prototype.startsWith" defer></script>

    <script src="{{ mix('/js/app.js') }}" defer></script>
    @routes
</head>
<body class="font-sans leading-none text-gray-700 antialiased">

@inertia

  <script src="/assets/js/jquery-3.3.1.min.js"></script>
  <script src="/assets/js/bootstrap.min.js"></script>
  <script src="/assets/js/jquery.magnific-popup.min.js"></script>
  <script src="/assets/js/jquery-ui.min.js"></script>
  <script src="/assets/js/mixitup.min.js"></script>
  <script src="/assets/js/jquery.countdown.min.js"></script>
  <script src="/assets/js/jquery.slicknav.js"></script>
  <script src="/assets/js/owl.carousel.min.js"></script>
  <script src="/assets/js/jquery.nicescroll.min.js"></script>
  <script src="/assets/js/main.js"></script>
</body>
</html>
