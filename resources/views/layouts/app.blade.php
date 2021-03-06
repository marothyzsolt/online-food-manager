<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!-- favicon -->
    <link rel="shortcut icon" href="/assets/images/favicon.png" type="image/png">
    <!-- animate scss -->
    <link rel="stylesheet" href="/assets/css/animate.css">
    <!-- bootstarp css -->
    <link rel="stylesheet" href="/assets/css/bootstrap.min.css">
    <!-- icofont -->
    <link rel="stylesheet" href="/assets/css/icofont.min.css">
    <!-- lightcase css -->
    <link rel="stylesheet" href="/assets/css/lightcase.css">
    <!-- swiper css -->
    <link rel="stylesheet" href="/assets/css/swiper.min.css">

    <link href="/assets/css/main.css" rel="stylesheet">
    <link href="{{ mix('/css/sass/app.css') }}" rel="stylesheet">
    <script src="{{ mix('/js/app.js') }}"></script>

    @yield('stylesheet')

    <title>Online Food Manager</title>
</head>

<body>
<!-- preloader -->
<div class="preloader"><div class="load loade"><hr/><hr/><hr/><hr/></div></div>
<!-- preloader -->

@include('layouts.components.header.mobile_nav')
@include('layouts.components.header.header')

@if (\Session::has('cart'))
    @if (\Session::get('cart') === 'restaurant_error')
        <div class="alert alert-danger mb-0 text-center">
            Már a kosaradban van egy termék a '<a href="{{ $cart->cart->restaurant->link }}">{{ $cart->cart->restaurant->name }}</a>' étteremből. Egyszerre csak egy étteremből rendelhetsz!
            <br>
            <a href="{{ $cart->cart->restaurant->link }}">Elérhető kínálat megtekintése...</a>
        </div>
    @endif
@endif

@if (\Session::has('message'))
    <div class="alert alert-danger mb-0 text-center">
        {{ \Session::get('message') }}
    </div>
@endif

@yield('main')

@include('layouts.components.footer.footer')


<!-- scrollToTop start here -->
<a href="#" class="scrollToTop"><i class="icofont-swoosh-up"></i></a>
<!-- scrollToTop ending here -->

<script src="/assets/js/jquery.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="/assets/js/waypoints.min.js"></script>
<script src="/assets/js/bootstrap.min.js"></script>
<script src="/assets/js/isotope.pkgd.min.js"></script>
<script src="/assets/js/wow.min.js"></script>
<script src="/assets/js/swiper.min.js"></script>
<script src="/assets/js/lightcase.js"></script>
<script src="/assets/js/jquery.counterup.min.js"></script>
<script src="/assets/js/functions.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>

@yield('script')

<script>
  $(function () {
    $('[data-toggle="tooltip"]').tooltip();
    $('.selectpicker').selectpicker();
  })
</script>
</body>
</html>