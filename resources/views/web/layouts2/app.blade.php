<!DOCTYPE html>
<html lang="en">

<head>
    <title>Reach Gems - Diamond Luxury Watch</title>

    {{-- SEO Meta --}}
    <meta name="description" content="Buy luxury diamond watches at Reach Gems. Explore premium collections of elegant timepieces.">
    <meta name="keywords" content="Luxury Watches, Diamond Watch, Reach Gems, Men's Watch, Women's Watch">
    <meta name="author" content="Reach Gems">

    {{-- Viewport & Charset --}}
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    {{-- Robots --}}
    <meta name="robots" content="index, follow">

    {{-- Open Graph (Social Sharing) --}}
    <meta property="og:title" content="Reach Gems - Diamond Luxury Watch">
    <meta property="og:description" content="Explore our exclusive diamond watch collection. Style meets elegance.">
    <meta property="og:image" content="{{ asset('public/assets/images/slider/slide-1.webp') }}">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:type" content="website">

    {{-- Twitter Card --}}
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Reach Gems - Diamond Luxury Watch">
    <meta name="twitter:description" content="Explore our exclusive diamond watch collection. Style meets elegance.">
    <meta name="twitter:image" content="{{ asset('public/assets/images/slider/slide-1.webp') }}">

    {{-- Favicon & Manifest --}}
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('public/assets/images/icons/favicon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('public/assets/images/icons/favicon.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('public/assets/images/icons/favicon.png') }}">
    <link rel="manifest" href="{{ asset('public/assets/images/icons/site.html') }}">
    <link rel="shortcut icon" href="{{ asset('public/assets/images/icons/favicon.png') }}">
    <meta name="apple-mobile-web-app-title" content="Reach Gems">
    <meta name="application-name" content="Reach Gems">
    <meta name="msapplication-TileColor" content="#cc9966">
    <meta name="msapplication-config" content="{{ asset('public/assets/images/icons/browserconfig.xml') }}">
    <meta name="theme-color" content="#ffffff">

    {{-- Preload Critical Image (LCP) --}}
    <link rel="preload" as="image" href="{{ asset('public/assets/images/slider/slide-1.webp') }}">
    <link rel="preload" as="image" href="{{ asset('public/assets/images/slider/slide-1-480w.webp') }}">
    <link rel="preload" as="image" href="{{ asset('public/assets/images/slider/slide-2.webp') }}">
    <link rel="preload" as="image" href="{{ asset('public/assets/images/slider/slide-2-480w.webp') }}">
    <link rel="preload" as="image" href="{{ asset('public/assets/images/slider/slide-3.webp') }}">
    <link rel="preload" as="image" href="{{ asset('public/assets/images/slider/slide-3-480w.webp') }}">

    {{-- CSS Files --}}
    <link rel="stylesheet" href="{{ asset('public/assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('public/assets/css/plugins/owl-carousel/owl.carousel.css') }}">
    <link rel="stylesheet" href="{{ asset('public/assets/css/plugins/magnific-popup/magnific-popup.css') }}">
    <link rel="stylesheet" href="{{ asset('public/assets/css/style.css') }}">
    <!-- <link rel="stylesheet" href="{{ asset('public/assets/css/plugins/nouislider/nouislider.css') }}">  -->

    @yield('css')
    <style>
        /* .text-muted, footer p, footer a {
            color: #545659 !important; 
        } */
    </style>
</head>
<body>
    <div class="page-wrapper">
        <!-- ======= Header ======= -->
        @include('web.layouts2._header')
        <!-- ======= End Header ======= -->

        <div id="main">
            @yield('content')
            <!-- ======= Header ======= -->
            @include('web.layouts2._footer')
            <!-- ======= End Header ======= -->
        </div>
    </div>

    <!-- ======= Mobile Menu  ======= -->
    @include('web.layouts2._mobile-menu')
    <!-- ======= End Mobile Menu  ======= -->
    <!-- ======= Mobile Menu  ======= -->
    @include('web.layouts2.signin-modal')
    <!-- ======= End Mobile Menu  ======= -->
    @yield('javascript')

    <!-- Vendor JS Files -->
    <script src="{{ asset('public/assets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('public/assets/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('public/assets/js/jquery.hoverIntent.min.js') }}"></script> 
    <script src="{{ asset('public/assets/js/jquery.waypoints.min.js') }}"></script> <!--  scrolls into view, triggering animations, counters, or events -->
    <!-- <script src="{{ asset('public/assets/js/superfish.min.js') }}"></script>   multi-level dropdown menus -->
    <script src="{{ asset('public/assets/js/owl.carousel.min.js') }}"></script> <!-- slider -->
    <script src="{{ asset('public/assets/js/jquery.elevateZoom.min.js') }}"></script> <!-- zoom functionality to product images -->
    <!-- <script src="{{ asset('public/assets/js/bootstrap-input-spinner.js') }}"></script> plus and minus buttons for incrementing or decrementing values -->
    <script src="{{ asset('public/assets/js/jquery.magnific-popup.min.js') }}"></script> <!-- responsive images, videos, galleries -->
    <script src="{{ asset('public/assets/js/main.js') }}"></script>
</body>
</html>