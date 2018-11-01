@extends('layouts.template')

{{-- Needed CSS --}}
@section('needed_css')
<link href="{{ asset('css/adminlte.css') }}" rel="stylesheet">
<link href="{{ asset('css/animate.css') }}" rel="stylesheet">
<link href="{{ asset('css/sweetalert.css') }}" rel="stylesheet">
@endsection{{-- /.Needed CSS --}}

@section('content')
<div class="register-box">
    <div class="register-logo">{{-- Register Logo --}}
        <a href="{{ url('/') }}"><b>Bakul</b>Visor</a>
    </div>{{-- /.Register Logo --}}

    <div class="card">{{-- Register Card --}}
        <div class="card-body register-card-body">
            <p class="login-box-msg">Register a new Account</p>

            <form role="form" id="registerForm">
                <div class="form-group" id="field-name">{{-- Full Name --}}
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Full Name" name="name" id="input-name">
                        <div class="input-group-append">
                            <span class="fa fa-user input-group-text" id="input_group-name"></span>
                        </div>
                    </div>
                </div>{{-- /.Full Name --}}
                <div class="form-group" id="field-email">{{-- Email --}}
                    <div class="input-group">
                        <input type="email" class="form-control" placeholder="E-mail" name="email" id="input-email">
                        <div class="input-group-append">
                            <span class="fa fa-envelope input-group-text" id="input_group-email"></span>
                        </div>
                    </div>
                </div>{{-- /.Email --}}
                <div class="form-group" id="field-username">{{-- Username --}}
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Username" name="username" id="input-username">
                        <div class="input-group-append">
                            <span class="fa fa-user input-group-text" id="input_group-username"></span>
                        </div>
                    </div>
                </div>{{-- /.Username --}}
                <div class="form-group" id="field-password">{{-- Password --}}
                    <div class="input-group">
                        <input type="password" class="form-control" placeholder="Password" name="password" id="input-password">
                        <div class="input-group-append">
                            <span class="fa fa-lock input-group-text" id="input_group-password"></span>
                        </div>
                    </div>
                </div>{{-- /.Password --}}
                <div class="form-group" id="field-password_confirmation">{{-- Password Confirm --}}
                    <div class="input-group">
                        <input type="password" class="form-control" placeholder="Re-Type Password" name="password_confirmation" id="input-password_confirmation">
                        <div class="input-group-append">
                            <span class="fa fa-lock input-group-text" id="input_group-password_confirmation"></span>
                        </div>
                    </div>
                </div>{{-- /.Password Confirm --}}

                <div class="btn-group w-100">{{-- Button  --}}
                    <button type="reset" class="btn btn-danger w-100">Reset</button>
                    <button type="submit" class="btn btn-primary w-100">Submit</button>
                </div>{{-- /.Button  --}}

                <p class="text-center mb-0 mt-2">Already have an Account? <a href="{{ url('/login') }}">Login here!</a></p>
            </form>
        </div>
        <!-- /.form-box -->
    </div>{{-- /.Register Card --}}
</div>
@endsection

{{-- Inline Js --}}
@section('inline_js')
<script>

    $(document).ready(function(){
        $.notify({
            icon: "done",
            title: "<strong>Success</strong>",
            message: "Coba"
        }, {
            type: "success",
            timer: 150000,
            delay: 500,
            newest_on_top: true,
            placement: {
                from: "top",
                align: "right"
            }
        });
    });

    $("#registerForm").submit(function(e){ //Prevent default Action for Form
        e.preventDefault();
        formAction();
    });

    //Form Action
    function formAction(){
        //Remove All Errors block that exists
        $(".error-block").remove();
        $(".form-control").removeClass('has-error');
        $(".input-group-text").removeClass('has-error');

        $.ajax({
            method: "POST",
            url: "{{ url('/register') }}",
            data: $("#registerForm").serialize(),
            cache: false,
            success: function(result){
                console.log(result);
                formReset();

                //Show Alert
                topright_notify(result);
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

                    console.log("Field : "+field_id+" / Text : "+result);
                });
            }
        });
    }
    //Reset Form Data
    function formReset(){
        $("#input-name").val('');
        $("#input-email").val('');
        $("#input-username").val('');
        $("#input-password").val('');
        $("#input-password_confirmation").val('');
    }
</script>
@endsection{{-- /.Inline Js --}}
