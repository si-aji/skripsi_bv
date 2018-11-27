@extends('layouts.template')

{{-- Needed CSS --}}
@section('needed_css')
<link href="{{ asset('css/adminlte.css') }}" rel="stylesheet">
<link href="{{ asset('css/sweetalert.css') }}" rel="stylesheet">
<link href="{{ asset('css/animate.css') }}" rel="stylesheet">
@endsection{{-- /.Needed CSS --}}

{{-- Content --}}
@section('content')
<div class="wrapper"><!-- Wrapper -->
    <nav class="main-header navbar fixed-top navbar-expand bg-white navbar-light elevation-1">{{-- Navbar --}}
        <ul class="navbar-nav">{{-- Left Navbar --}}
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#"><i class="fa fa-bars"></i></a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <a href="{{ url('/staff/dashboard') }}" class="nav-link">Dashboard</a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <a href="{{ url('/staff/profile') }}" class="nav-link" id="sub-profile">Profile</a>
            </li>
        </ul>{{-- /.Left Navbar --}}

        <!-- Right navbar links -->
        <ul class="navbar-nav ml-auto">{{-- Right Navbar --}}
            <li class="nav-item">
                <a href="#" onclick="logOut();" class="nav-link text-danger">Log Out</a>
            </li>
        </ul>{{-- /.Right Navbar --}}
    </nav>{{-- /.Navbar --}}

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Brand Logo -->
        <a href="{{ url('/staff') }}" class="brand-link elevation-1">
            <img src="{{ asset('img/bv/logo_helm.png') }}" alt="BakulVisor Logo" class="brand-image img-circle elevation-3" style="opacity: .8;padding: .3rem;">
            <span class="brand-text font-weight-light">BakulVisor</span>
        </a><!-- Brand Logo -->

        <!-- Sidebar -->
        <div class="sidebar">
            <!-- Sidebar user panel (optional) -->
            <div class="user-panel mt-3 pb-3 mb-3 d-flex flex-column">
                <div class="d-flex">
                    <div class="image">
                        <img src="{{ generate_gravatar(Auth::user()->name) }}" class="img-circle elevation-2" alt="User Image">
                    </div>
                    <div class="info">
                        <a href="#" class="d-block">{{ Auth::user()->name }}</a>
                    </div>
                </div>

                <div class="btn-group mt-3">
                    <a href="#" class="btn btn-primary text-white w-100">Profile</a>
                    <a href="#" onclick="logOut();" class="btn btn-danger text-white w-100">Log Out</a>
                </div>
            </div>

            <!-- Sidebar Menu -->
            <nav class="mt-2" id="nav_sidebar">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                    <!-- Add icons to the links using the .nav-icon class with font-awesome or any other icon font library -->
                    <li class="nav-item">
                        <a href="{{ url('/staff') }}" class="nav-link" id="mn-dashboard">
                            <i class="nav-icon fa fa-television"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>

                    <li class="nav-header">PRODUK</li>{{-- Produk --}}
                    <li class="nav-item">
                        <a href="{{ url('/staff/kategori') }}" class="nav-link" id="mn-kategori">
                            <i class="nav-icon fa fa-tags"></i>
                            <p>Kategori</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ url('/staff/barang') }}" class="nav-link" id="mn-barang">
                            <i class="nav-icon fa fa-th"></i>
                            <p>Barang</p>
                        </a>
                    </li>
                    {{-- /.Produk --}}

                    <li class="nav-header">DATA</li>{{-- Data --}}
                    <li class="nav-item">
                        <a href="{{ url('/staff/kostumer') }}" class="nav-link" id="mn-kostumer">
                            <i class="nav-icon fa fa-users"></i>
                            <p>Kostumer</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ url('/staff/supplier') }}" class="nav-link" id="mn-supplier">
                            <i class="nav-icon fa fa-truck"></i>
                            <p>Supplier</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ url('/staff/karyawan') }}" class="nav-link" id="mn-karyawan">
                            <i class="nav-icon fa fa-user"></i>
                            <p>Karyawan</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ url('/staff/toko') }}" class="nav-link" id="mn-toko">
                            <i class="nav-icon fa fa-home"></i>
                            <p>Toko</p>
                        </a>
                    </li>
                    {{--  /.Data  --}}

                    <li class="nav-header">TRANSAKSI</li>{{-- Transaksi --}}
                    <li class="nav-item has-treeview">{{-- Penjualan --}}
                        <a href="#" class="nav-link" id="mn-penjualan">
                            <i class="nav-icon fa fa-money"></i>
                            <p>
                                Penjualan
                                <i class="fa fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ url('/staff/penjualan') }}" class="nav-link" id="sub-penjualan_list">
                                    <i class="fa fa-circle-o nav-icon"></i>
                                    <p>List Penjualan</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ url('/staff/penjualan/create') }}" class="nav-link" id="sub-penjualan_tambah">
                                    <i class="fa fa-circle-o nav-icon"></i>
                                    <p>Tambah Penjualan</p>
                                </a>
                            </li>
                        </ul>
                    </li>{{-- /.Penjualan --}}
                    <li class="nav-item has-treeview">{{-- Pembelian --}}
                        <a href="#" class="nav-link" id="mn-pembelian">
                            <i class="nav-icon fa fa-usd"></i>
                            <p>
                                Pembelian
                                <i class="fa fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ url('/staff/pembelian') }}" class="nav-link"  id="sub-pembelian_list">
                                    <i class="fa fa-circle-o nav-icon"></i>
                                    <p>List Pembelian</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ url('/staff/pembelian/create') }}" class="nav-link" id="sub-pembelian_tambah">
                                    <i class="fa fa-circle-o nav-icon"></i>
                                    <p>Tambah Pembelian</p>
                                </a>
                            </li>
                        </ul>
                    </li>{{-- /.Pembelian --}}
                    {{--  /.Transaksi  --}}
                </ul>
            </nav><!-- /.Sidebar Menu -->
        </div><!-- /.Sidebar -->
    </aside>

    <!-- Content -->
    <div class="content-wrapper">
        <!-- Content Header -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        @yield('staff_content_title')
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        @yield('staff_content_breadcrumb')
                    </div>
                </div>
            </div>
        </div><!-- /.Content Header -->

            <!-- Main content -->
            <div class="content">
                <div class="container-fluid">
                    @yield('staff_content')
                </div>
            </div>
    </div><!-- Content -->

    <!-- Footer -->
    <footer class="main-footer">
        <!-- To the right -->
        <div class="float-right d-none d-sm-block-down">
            Anything you want
        </div>
        <!-- Default to the left -->
        Template by <strong><a href="https://adminlte.io">AdminLTE.io</a></strong>, Customized by <strong><a href="http://siaji.com/">siAJI</a></strong>. Copyright © 2018 - All rights reserved.
        <div class="copyright float-right">
            {{ version() }}  / Hand-crafted &amp; made in Yogyakarta, Indonesia
        </div>
    </footer><!-- Footer -->
</div><!-- /.Wrapper -->
@endsection{{-- Content --}}

{{-- Needed Js --}}
@section('needed_js')
{{--  <script src="{{ asset('js/app.js') }}"></script>  --}}
<script src="{{ asset('js/adminlte.js') }}"></script>
{{--  <script src="{{ asset('js/demo.js') }}"></script>  --}}
<script src="{{ asset('plugins/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
<!-- Bootstrap -->
<script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.js') }}"></script>
<!-- Popper Js -->
<script src="{{ asset('plugins/popper/umd/popper.js') }}"></script>
<!-- Momment Js -->
<script src="{{ asset('js/momment.js') }}"></script>


<!-- Plugins -->
<script src="{{ asset('plugins/sweetalert/sweetalert.min.js') }}"></script><!-- Sweet Alert -->
@endsection{{-- /.Needed Js --}}
{{-- Inline Js --}}
@section('important_inline_js')
<script>
    $(document).ready(function(){
        $("body").addClass('hold-transition sidebar-mini');

        $(".sidebar").perfectScrollbar({
            suppressScrollX: true
        });
    });

    //Log out function
    function logOut(){
        swal({
            title: "Warning!",
            text: "Do you really want to logout?",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        }).then((value) => {
            if (value) {
                $.ajax({
                    method: "POST",
                    url: "{{ route('logout') }}",
                    cache: false,
                    success: function(result){
                        //console.log(result);
                        //Redirect to login page
                        showSuccess_redirect(result, "{{ url('/login') }}");
                    },
                    error: function( jqXHR, textStatus, errorThrown ) {
                        //console.log(jqXHR);
                    }
                });
            }
        });
    }

    function showSwal(){
        swal(
            'Good job!',
            'You clicked the button!',
            'success'
        );
    }
</script>
@endsection{{-- /.Inline Js --}}
