<!DOCTYPE html>
<html lang="en">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="BakulVisor, Sedia perlengkapan maupun aksesoris helm. Posisi Yogyakarta, Siap pengiriman luar kota">
        <meta name="author" content="siaji.com">
        <meta name="keyword" content="bakulvisor, helm, aksesoris, aksesoris helm, kyt, nhk, ink">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <meta property="og:title" content="BakulVisor" />
        <meta property="og:site_name" content="Bakul Visor" />
        <meta property="og:type" content="portfolio" />
        <meta property="og:url" content="httpL://bakulvisor.siaji.com" />
        <meta property="og:description" content="BakulVisor, Sedia perlengkapan maupun aksesoris helm. Posisi Yogyakarta, Siap pengiriman luar kota" />
        <meta property="og:image" content="#" />

        <meta name="twitter:card">
        <meta name="twitter:image">
        <meta name="twitter:title">
        <meta name="twitter:description">
        <meta name="twitter:site">

        <title>Bakul Visor</title>

        <meta name="robots" content="index,follow">
        <link rel="shortcut icon" href="#"/>

        <!-- CSS -->

        <!-- Font Awesome -->
        <link href="{{ asset('plugins/font-awesome/css/font-awesome.css') }}" rel="stylesheet">
        <!-- Google Fonts -->
        <link href="{{ asset('plugins/google_fonts/css/google_fonts.css') }}" rel="stylesheet">
        @yield('needed_css')
        @yield('custom_css')

        <!-- CSS for Plugin -->
        @yield('plugin_css')

        {{-- Inline CSS --}}
        @yield('style')
    </head>

    <body>
        @yield('content')
    </body>

    <!-- Require Js -->
    <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap -->
    <script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.js') }}"></script>
    <!-- Popper Js -->
    <script src="{{ asset('plugins/popper/umd/popper.js') }}"></script>
    {{--  Needed Js --}}
    @yield('needed_js')
    @yield('custom_js')

    {{-- Inline Js --}}
    @yield('inline_js')
</html>
