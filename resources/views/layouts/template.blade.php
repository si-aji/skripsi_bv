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
        <link rel="shortcut icon" href="{{ asset('img/bv/logo_helm.png') }}"/>

        <!-- CSS -->

        <!-- Font Awesome -->
        <link href="{{ asset('plugins/font-awesome/css/font-awesome.css') }}" rel="stylesheet">
        <!-- Google Fonts -->
        <link href="{{ asset('plugins/google_fonts/css/google_fonts.css') }}" rel="stylesheet">
        <!-- Require CSS -->
        <link href="{{ asset('css/sa_bv.css') }}" rel="stylesheet">
        @yield('needed_css')
        @yield('custom_css')

        <!-- CSS for Plugin -->
        @yield('plugin_css')

        {{-- Inline CSS --}}
        @yield('style')
    </head>

    <body>
        @yield('content')

        <div id="ajax-loading">{{-- Loading / Show on Ajax Request --}}
            <div id="ajax-loading_content">
                <span class="fa fa-spinner fa-spin fa-3x"></span>
            </div>
        </div>{{-- Loading / Show on Ajax Request --}}
    </body>

    <!-- Require Js -->
    <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
    <!-- Notify Js -->
    {{--  <script src="{{  asset('js/bootstrap-notify.js')}}"></script>  --}}
    <script src="{{ asset('plugins/bootstrap-notify/notify.js') }}"></script>

    <script src="{{ asset('js/sa_bv.js') }}"></script>
    {{--  Needed Js --}}
    @yield('needed_js')
    @yield('plugins_js')
    @yield('custom_js')

    {{-- Inline Js --}}
    <script>
        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip();
        });
        $.ajaxSetup({ {{-- Set csrf token for every ajax request --}}
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
        });
        $(document).ajaxSend(function(event, request, settings){ {{-- Show modal every ajax request --}}
            $("#ajax-loading").show();
        });
        $(document).ajaxComplete(function(event, request, settings){ {{-- Hide modal after ajax request --}}
            $("#ajax-loading").hide();
        });
    </script>
    @yield('important_inline_js')
    @yield('inline_js')
</html>
