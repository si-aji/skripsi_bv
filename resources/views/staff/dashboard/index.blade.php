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
</script>
@endsection
