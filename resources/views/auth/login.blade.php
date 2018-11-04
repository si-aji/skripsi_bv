@extends('layouts.template')

{{-- Needed CSS --}}
@section('needed_css')
<link href="{{ asset('css/adminlte.css') }}" rel="stylesheet">
<link href="{{ asset('css/animate.css') }}" rel="stylesheet">
<link href="{{ asset('css/sweetalert.css') }}" rel="stylesheet">
@endsection{{-- /.Needed CSS --}}

@section('content')
<div class="login-box">
    <div class="login-logo">{{-- Register Logo --}}
        <a href="{{ url('/') }}"><b>Bakul</b>Visor</a>
    </div>{{-- /.Register Logo --}}

    <div class="card">{{-- Register Card --}}
        <div class="card-body login-card-body">
            <div id="alert_section"></div>

            @if (session('confirmation-success'))
                <div class="alert alert-success">
                    {{ session('confirmation-success') }}
                </div>
            @endif

            <p class="login-box-msg">Login to existing Account</p>

            <form role="form" id="loginForm">
                <div class="form-group" id="field-email">{{-- Username/Email --}}
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Email / Username" name="email" id="input-email">
                        <div class="input-group-append">
                            <span class="fa fa-user input-group-text" id="input_group-email"></span>
                        </div>
                    </div>
                </div>{{-- /.Username/Email --}}
                <div class="form-group" id="field-name">{{-- Password --}}
                    <div class="input-group">
                        <input type="password" class="form-control" placeholder="Password" name="password" id="input-password">
                        <div class="input-group-append">
                            <span class="fa fa-lock input-group-text" id="input_group-password"></span>
                        </div>
                    </div>
                </div>{{-- /.Password --}}

                <div class="btn-group w-100">{{-- Button  --}}
                    <button type="reset" class="btn btn-danger w-100">Reset</button>
                    <button type="submit" class="btn btn-primary w-100">Submit</button>
                </div>{{-- /.Button  --}}

                <p class="text-center mb-1 mt-2"><small><a href="{{ url('/password/reset') }}">Forgot your password?</a></small></p>
                <p class="text-center mb-0 mt-2">Didnt have an Account yet? <a href="{{ url('/register') }}">Register first!</a></p>
            </form>
        </div>
    </div>{{-- /.Register Card --}}
</div>
@endsection

{{--  Require Js  --}}
@section('needed_js')
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script><!-- Sweet Alert -->
@endsection

{{-- Inline Js --}}
@section('inline_js')
<script>
    //Resend Link
    function resend_link(){
        //Resend email verify code via ajax
        $.ajax({
            method: "GET",
            url: "{{ url('/confirmation/resend') }}",
            success: function(result){
                //console.log(result);
                //Remove Alert Message
                $("#resend_alert").remove();
                $("#alert_section").append('<div class="alert alert-info alert-dismissible" id="resend_alert"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h5><i class="icon fa fa-info"></i> Alert!</h5><small>'+result+'</small></div>');
            },
            error: function( jqXHR, textStatus, errorThrown ) {
                console.log(jqXHR);
            }
        });
    }

    $("#loginForm").submit(function(e){ //Prevent default Action for Form
        e.preventDefault();
        formAction();
    });

    //Form Action
    function formAction(){
        //Remove All Errors block that exists
        $(".error-block").remove();
        $(".form-control").removeClass('has-error');
        $(".input-group-text").removeClass('has-error');
        //Remove Alert Message
        $("#resend_alert").remove();

        $.ajax({
            method: "POST",
            url: "{{ url('/login') }}",
            data: $("#loginForm").serialize(),
            cache: false,
            success: function(result){
                //console.log(result);

                if(result.includes("verify")){
                    //Account didnt verify email yet
                    $("#alert_section").append('<div class="alert alert-info alert-dismissible" id="resend_alert"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h5><i class="icon fa fa-info"></i> Alert!</h5><small>'+result+'</small></div>');
                } else {
                    //Successfully Logged in
                    showSuccess_redirect(result, "{{ url('/staff') }}")
                }
                //formReset();

                //Show Alert
                //topright_notify(result);
            },
            error: function( jqXHR, textStatus, errorThrown ) {
                //console.log(jqXHR);

                //Print All Error text
                $.each(jqXHR.responseJSON.errors, function(key, result) {
                    var field_id = "field-"+key;
                    var input_id = "input-"+key;
                    var input_group_id = "input_group-"+key;
                    //Append Error Field
                    $("#"+input_id).addClass('has-error');
                    $("#"+input_group_id).addClass('has-error');
                    //Append Error Message
                    $("#"+field_id).append("<div class='text-muted error-block'><span class='help-block'><small>"+result+"</small></span></div>");

                //    console.log("Field : "+field_id+" / Text : "+result);
                });
            }
        });
    }
</script>
@endsection
