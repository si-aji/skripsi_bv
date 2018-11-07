@extends('layouts.staff')

{{-- Content Header --}}
@section('staff_content_title')
    <h1 class="m-0 text-dark">Profile</h1>
@endsection
@section('staff_content_breadcrumb')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="{{ url('/staff') }}">Home</a></li>
        <li class="breadcrumb-item active">Profile</li>
    </ol>
@endsection{{-- Content Header --}}

@section('staff_content')
    <div class="row">
        <div class="col-12 col-lg-4">{{-- Form Karyawan --}}
            <div class="card">
                <div class="card-header no-border">
                    <h3 class="card-title"><i class="fa fa-user"></i> <span id="span_title">Form Profile</span></h3>
                </div>
                <form role="form" id="karyawanForm">
                    <div class="card-body">
                        <input type="hidden" name="request" id="request" value="update">
                        <input type="hidden" name="_method" id="_method" value="put">
                        <input type="hidden" name="id" id="user_id" value="{{ Auth::User()->id }}">

                        <div class="form-group" id="field-name">{{-- Nama User --}}
                            <label for="input-name">Nama</label>
                            <input type="text" name="name" class="form-control" placeholder="Nama" id="input-name" value="{{ Auth::User()->name }}">
                        </div>{{-- /.Nama User --}}

                        <div class="form-group" id="field-username">{{-- UserName --}}
                            <label for="input-username">Username</label>
                            <input type="text" name="username" class="form-control" placeholder="Username" id="input-username" value="{{ Auth::User()->username }}">
                        </div>{{-- /.UserName --}}

                        <div class="form-group" id="field-email">{{-- Email --}}
                            <label for="input-email">E-mail</label>
                            <input type="email" name="email" class="form-control" placeholder="mail@domain.com" id="input-email" value="{{ Auth::User()->email }}">
                        </div>{{-- /.Email --}}

                        <div class="form-group" id="field-password">{{-- Password --}}
                            <label for="input-password">Password</label>
                            <input type="password" name="password" class="form-control" placeholder="Password" id="input-password">
                        </div>{{-- /.Password --}}
                        <div class="form-group" id="field-password_confirmation">{{-- Password Confirmation --}}
                            <label for="input-password_confirmation">Re-type Password</label>
                            <input type="password" name="password_confirmation" class="form-control" placeholder="Re-type Password" id="input-password_confirmation">
                        </div>{{-- /.Password Confirmation --}}
                    </div>
                    <div class="card-footer">
                        <div class="form-group text-right">
                            <button type="reset" id="formReset" class="btn btn-danger text-white">Reset</button>
                            <button type="submit" class="btn btn-primary text-white">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>{{-- /.Form Karyawan --}}
        <div class="col-12 col-lg-8">{{-- DataTable Karyawan --}}
            <div class="card">
                <div class="card-body">
                    <table class="table table-hover table-striped" id="karyawanTable">
                        <tr>
                            <th>Name</th>
                            <td class="all">{{ Auth::User()->name }}</td>
                        </tr>
                        <tr>
                            <th>Username</th>
                            <td class="all">{{ Auth::User()->username }}</td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td class="desktop">@if(Auth::User()->email) {{ Auth::User()->email }} @else - @endif</td>
                        </tr>
                        <tr>
                            <th>Email Status</th>
                            <td class="desktop">@if(Auth::User()->email != "") @if(Auth::User()->email_verified_at != "") <i class="fa fa-check"></i> Verified @else <i class="fa fa-close"></i> Not Verified @endif @else - @endif</td>
                        </tr>
                        <tr>
                            <th>Level</th>
                            <td class="desktop">{{ Auth::User()->level }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>{{-- /.DataTable Karyawan --}}
    </div>
@endsection

@section('inline_js')
<script>
    $(document).ready(function(){
        document.title = "BakulVisor | Profile";
        $("#sub-profile").addClass('active');
    });

    $("#karyawanForm").submit(function(e){ //Prevent default Action for Form
        e.preventDefault();
        formAction();
    });
    //Form Action
    function formAction(){
        //Remove All Errors block that exists
        $(".error-block").remove();
        $(".form-control").removeClass('has-error');
        $(".input-group-text").removeClass('has-error');

        var formMethod = $("#_method").val();
        var url_link = "{{ url('/staff/profile/update') }}/"+$("#user_id").val();

        $.ajax({
            method: formMethod,
            url: url_link,
            data: $("#karyawanForm").serialize(),
            cache: false,
            success: function(result){
                console.log(result);

                //Show alert
                //topright_notify(result.message);
                //Re-Draw dataTable
                //$("#karyawanTable").DataTable().ajax.reload(null, false);
                //ResetForm
                //formReset();
            },
            error: function( jqXHR, textStatus, errorThrown ) {
                console.log(jqXHR);

                //Print all error message
                $.each(jqXHR.responseJSON.errors, function(key, result) {
                    var field_id = "field-"+key;
                    var input_id = "input-"+key;
                    var input_group_id = "input_group-"+key;
                    //Append Error Field
                    $("#"+input_id).addClass('has-error');
                    $("#"+input_group_id).addClass('has-error');
                    //Append Error Message
                    $("#"+field_id).append("<div class='text-muted error-block'><span class='help-block'><small>"+result+"</small></span></div>");
                });
            }
        });
    }
</script>
@endsection
