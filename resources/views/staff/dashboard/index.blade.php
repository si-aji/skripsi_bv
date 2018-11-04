@extends('layouts.staff')

{{-- Content Header --}}
@section('staff_content_title')
    <h1 class="m-0 text-dark">Dashboard</h1>
@endsection
@section('staff_content_breadcrumb')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="{{ url('/staff') }}">Home</a></li>
        <li class="breadcrumb-item active">Dashboard</li>
    </ol>
@endsection{{-- Content Header --}}

@section('staff_content')
    @if(Auth::User()->email == "")
    <div class="alert alert-warning">
        <h5><i class="icon fa fa-info"></i> Warning Alert!</h5>
        <small>Please add an email to secure your account</small>
    </div>
    @elseif(Auth::User()->email != "" && Auth::User()->email_verified_at == "")
    <div class="alert alert-warning">
        <h5><i class="icon fa fa-info"></i> Warning Alert!</h5>
        <small>
            Please check your email to verify. If you have not received the confirmation email check your spam folder
            <br>To get a new confirmation email please <a href="#" onclick="resend_link()" class="alert-link">click here</a>.
        </small>
    </div>
    @endif

    @if (session('confirmation-success'))
        <div class="alert alert-success">
            {{ session('confirmation-success') }}
        </div>
    @endif

    <div id="alert_section"></div>

    <div class="card">
        <div class="card-header no-border">
            <h3 class="card-title"><span>Dashboard</span></h3>
        </div>
        <div class="card-body">
            <a onclick="showSwal()" class="btn btn-primary">Show SweetAlert2</a>
        </div>
    </div>
@endsection

@section('inline_js')
<script>
    $(document).ready(function(){
        $("#mn-dashboard").addClass('active');
    });

    //Resend Link
    function resend_link(){
        //Resend email verify code via ajax
        $.ajax({
            method: "GET",
            url: "{{ url('/confirmation/resend') }}",
            success: function(result){
                console.log(result);
                $("#alert_section").append('<div class="alert alert-info alert-dismissible" id="resend_alert"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h5><i class="icon fa fa-info"></i> Alert!</h5><small>'+result+'</small></div>');
            },
            error: function( jqXHR, textStatus, errorThrown ) {
                console.log(jqXHR);
            }
        });
    }
</script>
@endsection
