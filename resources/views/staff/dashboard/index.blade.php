@extends('layouts.staff')

{{-- Content Header --}}
@section('staff_content_title')
    <h1 class="m-0 text-dark">Dashboard v3</h1>
@endsection
@section('staff_content_breadcrumb')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="#">Home</a></li>
        <li class="breadcrumb-item active">Dashboard v3</li>
    </ol>
@endsection{{-- Content Header --}}

@section('staff_content')
    Dashboard <a onclick="showSwal()" class="btn btn-primary">Show SweetAlert2</a>
@endsection
