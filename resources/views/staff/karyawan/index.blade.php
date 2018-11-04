@extends('layouts.staff')

{{--  Require CSS for this Page  --}}
@section('plugin_css')
    <link href="{{ asset('plugins/dataTables/datatables.css') }}" rel="stylesheet">
@endsection

{{-- Content Header --}}
@section('staff_content_title')
    <h1 class="m-0 text-dark">Karyawan</h1>
@endsection
@section('staff_content_breadcrumb')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="{{ url('/staff') }}">Home</a></li>
        <li class="breadcrumb-item active">Karyawan</li>
    </ol>
@endsection{{-- Content Header --}}

@section('staff_content')
    <div class="row">
        <div class="col-12 col-lg-4">{{-- Form Karyawan --}}
            <div class="card">
                <div class="card-header no-border">
                    <h3 class="card-title"><i class="fa fa-user"></i> <span id="span_title">Form Karyawan (Insert)</span></h3>
                </div>
                <form role="form" id="karyawanForm">
                    <div class="card-body">
                        <input type="hidden" name="request" id="request" value="insert">
                        <input type="hidden" name="_method" id="_method" value="POST">
                        <input type="hidden" name="id" id="user_id">

                        <div class="form-group" id="field-name">{{-- Nama User --}}
                            <label for="input-name">Nama</label>
                            <input type="text" name="name" class="form-control" placeholder="Nama" id="input-name">
                        </div>{{-- /.Nama User --}}

                        <div class="form-group" id="field-username">{{-- UserName --}}
                            <label for="input-username">Username</label>
                            <input type="text" name="username" class="form-control" placeholder="Username" id="input-username">
                        </div>{{-- /.UserName --}}

                        <div class="form-group" id="field-email">{{-- Email --}}
                            <label for="input-email">E-mail</label>
                            <input type="email" name="email" class="form-control" placeholder="mail@domain.com" id="input-email">
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
                <div class="card-header no-border">
                    <h3 class="card-title"><span><i class="fa fa-user"></i> List Karyawan</span></h3>
                </div>
                <div class="card-body">
                    <table class="table table-hover table-striped table-bordered" id="karyawanTable">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th class="all">Nama</th>
                                <th class="all">Username</th>
                                <th class="desktop">Email</th>
                                <th class="desktop">Level</th>
                                <th class="desktop">Aksi</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>{{-- /.DataTable Karyawan --}}
    </div>
@endsection

{{--  Require Js for this page  --}}
@section('plugins_js')
    <script src="{{ asset('plugins/dataTables/datatables.js') }}"></script>
    <script src="{{ asset('plugins/dataTables/Responsive-2.2.1/js/datatables.responsive.js') }}"></script>
@endsection

@section('inline_js')
<script>
    $(document).ready(function(){
        document.title = "BakulVisor | Karyawan";
        $("#mn-karyawan").addClass('active');
    });

    var tkaryawan = $("#karyawanTable").DataTable({
        responsive: true,
        processing: true,
        autoWidth: true,
        ajax: {
            method: "GET",
            url: "{{ url('list/karyawan') }}",
        },
        columns: [
            { data: null },
            { data: 'name' },
            { data: 'username' },
            { data: null },
            { data: 'level' },
            { data: null },
        ],
        columnDefs: [
            {
                targets: [0],
                searchable: false,
                orderable: false,
            }, {
                targets: [3],
                render: function(data, type, row) {
                    if(data.email != "" && data.email != "null" && data.email != null){
                        var user_stat;

                        if(data.email_verified_at != "" && data.email_verified_at != "null"  && data.email_verified_at != null){
                            user_stat = "<i class='fa fa-check' data-toggle='tooltip' data-placement='top' title='Email is verified!'></i>";
                        } else {
                            user_stat = "<i class='fa fa-close' data-toggle='tooltip' data-placement='top' title='Email is not yet verified!'></i>";
                        }

                        return "<span>("+user_stat+") "+data.email+"</span>";
                    } else {
                        return "<span>-</span>";
                    }
                }
            }, {
                targets: [5],
                render: function(data, type, row) {
                    var id = "'"+data.id+"'";
                    return generateButton(id);
                }
            }
        ],
        pageLength: 10,
        aLengthMenu:[5,10,15,25,50],
        order: [1, 'asc'],
        responsive: {
            details: {
                type: 'column',
                target: 'tr'
            }
        }
    });
    tkaryawan.on( 'order.dt search.dt', function () {
        tkaryawan.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
            cell.innerHTML = i+1;
        });
    }).draw();
    function generateButton(id){
        var edit = '<a class="btn btn-warning text-white" onclick="formUpdate('+id+')"></i><i class="fa fa-edit"></i></a>';
        var hapus = '<a class="btn btn-danger text-white" onclick="formDelete('+id+')"><i class="fa fa-trash"></i></a>';

        return "<div class='btn-group'>"+edit+hapus+"</div>";
    }

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

        if($("#request").val() == "insert"){
            //Insert
            var formMethod = $("#_method").val();
            var url_link = "{{ url('/staff/karyawan') }}";
        } else {
            //Update
            var formMethod = $("#_method").val();
            var url_link = "{{ url('/staff/karyawan') }}/"+$("#karyawan_id").val();
        }

        $.ajax({
            method: formMethod,
            url: url_link,
            data: $("#karyawanForm").serialize(),
            cache: false,
            success: function(result){
                console.log(result);

                //Show alert
                topright_notify(result.message);
                //Re-Draw dataTable
                $("#tokoTable").DataTable().ajax.reload(null, false);
                //ResetForm
                formReset();
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
