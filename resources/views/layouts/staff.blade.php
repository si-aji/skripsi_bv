@extends('layouts.template')

{{-- Needed CSS --}}
@section('needed_css')
<link href="{{ asset('css/adminlte.css') }}" rel="stylesheet">
<link href="{{ asset('css/sweetalert.css') }}" rel="stylesheet">
@endsection{{-- /.Needed CSS --}}

{{-- Content --}}
@section('content')
<div class="wrapper"><!-- Wrapper -->
    <nav class="main-header navbar navbar-expand bg-white navbar-light elevation-1">{{-- Navbar --}}
        <ul class="navbar-nav">{{-- Left Navbar --}}
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#"><i class="fa fa-bars"></i></a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <a href="index3.html" class="nav-link">Home</a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <a href="#" class="nav-link">Contact</a>
            </li>
        </ul>{{-- /.Left Navbar --}}

        {{-- Search --}}
        <form class="form-inline ml-3">
            <div class="input-group input-group-sm">
                <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
                <div class="input-group-append">
                    <button class="btn btn-navbar" type="submit">
                        <i class="fa fa-search"></i>
                    </button>
                </div>
            </div>
        </form>{{-- /.Search --}}

        <!-- Right navbar links -->
        <ul class="navbar-nav ml-auto">
            <!-- Messages Dropdown Menu -->
            <li class="nav-item dropdown">
                <a class="nav-link" data-toggle="dropdown" href="#">
                    <i class="fa fa-comments-o"></i>
                    <span class="badge badge-danger navbar-badge">3</span>
                </a>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                    <a href="#" class="dropdown-item">
                        <!-- Message Start -->
                        <div class="media">
                            <img src="{{ asset('img/user1-128x128.jpg') }}" alt="User Avatar" class="img-size-50 mr-3 img-circle">
                            <div class="media-body">
                                <h3 class="dropdown-item-title">
                                    Brad Diesel
                                    <span class="float-right text-sm text-danger"><i class="fa fa-star"></i></span>
                                </h3>
                                <p class="text-sm">Call me whenever you can...</p>
                                <p class="text-sm text-muted"><i class="fa fa-clock-o mr-1"></i> 4 Hours Ago</p>
                            </div>
                        </div>
                        <!-- Message End -->
                    </a>
                    <div class="dropdown-divider"></div>

                    <a href="#" class="dropdown-item">
                        <!-- Message Start -->
                        <div class="media">
                            <img src="{{ asset('img/user8-128x128.jpg') }}" alt="User Avatar" class="img-size-50 img-circle mr-3">
                            <div class="media-body">
                                <h3 class="dropdown-item-title">
                                    John Pierce
                                    <span class="float-right text-sm text-muted"><i class="fa fa-star"></i></span>
                                </h3>
                                <p class="text-sm">I got your message bro</p>
                                <p class="text-sm text-muted"><i class="fa fa-clock-o mr-1"></i> 4 Hours Ago</p>
                            </div>
                        </div>
                        <!-- Message End -->
                    </a>
                    <div class="dropdown-divider"></div>

                    <a href="#" class="dropdown-item">
                        <!-- Message Start -->
                        <div class="media">
                            <img src="{{ asset('img/user3-128x128.jpg') }}" alt="User Avatar" class="img-size-50 img-circle mr-3">
                            <div class="media-body">
                                <h3 class="dropdown-item-title">
                                    Nora Silvester
                                    <span class="float-right text-sm text-warning"><i class="fa fa-star"></i></span>
                                </h3>
                                <p class="text-sm">The subject goes here</p>
                                <p class="text-sm text-muted"><i class="fa fa-clock-o mr-1"></i> 4 Hours Ago</p>
                            </div>
                        </div>
                        <!-- Message End -->
                    </a>
                    <div class="dropdown-divider"></div>

                    <a href="#" class="dropdown-item dropdown-footer">See All Messages</a>
                </div>
            </li>

            <!-- Notifications Dropdown Menu -->
            <li class="nav-item dropdown">
                <a class="nav-link" data-toggle="dropdown" href="#">
                    <i class="fa fa-bell-o"></i>
                    <span class="badge badge-warning navbar-badge">15</span>
                </a>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                    <span class="dropdown-item dropdown-header">15 Notifications</span>
                    <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item">
                            <i class="fa fa-envelope mr-2"></i> 4 new messages
                            <span class="float-right text-muted text-sm">3 mins</span>
                        </a>
                    <div class="dropdown-divider"></div>

                    <a href="#" class="dropdown-item">
                        <i class="fa fa-users mr-2"></i> 8 friend requests
                        <span class="float-right text-muted text-sm">12 hours</span>
                    </a>
                    <div class="dropdown-divider"></div>

                    <a href="#" class="dropdown-item">
                        <i class="fa fa-file mr-2"></i> 3 new reports
                        <span class="float-right text-muted text-sm">2 days</span>
                    </a>
                    <div class="dropdown-divider"></div>

                    <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
                </div>
            </li>

            <li class="nav-item">
                <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#"><i class="fa fa-th-large"></i></a>
            </li>
        </ul>
    </nav>{{-- /.Navbar --}}

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Brand Logo -->
        <a href="index3.html" class="brand-link elevation-1">
            <img src="{{ generate_gravatar('Bakul Visor') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
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
                    <li class="nav-item has-treeview menu-open active">
                        <a href="#" class="nav-link active">
                            <i class="nav-icon fa fa-dashboard"></i>
                            <p>
                                Dashboard
                                <i class="right fa fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="./index.html" class="nav-link">
                                    <i class="fa fa-circle-o nav-icon"></i>
                                        <p>Dashboard v1</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="./index2.html" class="nav-link">
                                    <i class="fa fa-circle-o nav-icon"></i>
                                    <p>Dashboard v2</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item has-treeview">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fa fa-tree"></i>
                            <p>
                                UI Elements
                                <i class="fa fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="pages/UI/general.html" class="nav-link">
                                    <i class="fa fa-circle-o nav-icon"></i>
                                    <p>General</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="pages/UI/icons.html" class="nav-link">
                                    <i class="fa fa-circle-o nav-icon"></i>
                                    <p>Icons</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="pages/UI/buttons.html" class="nav-link">
                                    <i class="fa fa-circle-o nav-icon"></i>
                                    <p>Buttons</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="pages/UI/sliders.html" class="nav-link">
                                    <i class="fa fa-circle-o nav-icon"></i>
                                    <p>Sliders</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a href="pages/widgets.html" class="nav-link">
                            <i class="nav-icon fa fa-th"></i>
                            <p>
                                Widgets
                                <span class="right badge badge-danger">New</span>
                            </p>
                        </a>
                    </li>

                    <li class="nav-header">MISCELLANEOUS</li>

                    <li class="nav-item">
                        <a href="https://adminlte.io/docs" class="nav-link">
                            <i class="nav-icon fa fa-file"></i>
                            <p>Documentation</p>
                        </a>
                    </li>

                    <li class="nav-header">LABELS</li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fa fa-circle-o text-danger"></i>
                            <p class="text">Important</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fa fa-circle-o text-warning"></i>
                            <p>Warning</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fa fa-circle-o text-info"></i>
                            <p>Informational</p>
                        </a>
                    </li>
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
<script src="{{ asset('js/app.js') }}"></script>
<script src="{{ asset('js/adminlte.js') }}"></script>
<script src="{{ asset('js/demo.js') }}"></script>
<script src="{{ asset('js/sa_bv.js') }}"></script>
<script src="http://list.siaji.com/js/plugins/perfect-scrollbar.jquery.min.js"></script>

<!-- Plugins -->
<script src="{{ asset('plugins/sweetalert/sweetalert.min.js') }}"></script><!-- Sweet Alert -->
@endsection{{-- /.Needed Js --}}
{{-- Inline Js --}}
@section('inline_js')
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
