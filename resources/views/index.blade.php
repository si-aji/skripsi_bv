@extends('layouts.template')

{{-- Needed CSS --}}
@section('needed_css')
<link href="{{ asset('css/adminlte.css') }}" rel="stylesheet">
@endsection{{-- /.Needed CSS --}}

{{-- Content --}}
@section('content')
<div class="container"><!-- Wrapper -->
    <div class="row">
        <div class="col-12 col-lg-6 mx-auto">
            <div class="brand_image"><img src="{{ asset('img/bv/logo.png') }}" alt="Bakulvisor Logo"></div>
        </div>
    </div>
</div>
@endsection

@section('custom_js')
    <script>
        $(document).ready(function(){
            $('body').addClass('bg-bakulvisor-gradient');
        });
    </script>
@endsection
