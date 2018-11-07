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
                                <th class="desktop">Status</th>
                                <th class="desktop">Aksi</th>
                            </tr>
                        </thead>
                    </table>
                    <div class="card">{{-- Legendary --}}
                        <div class="card-body">
                            <span><small>Action Button description</small></span><br>
                            <div class="btn-group">
                                <button class="btn btn-sm btn-warning text-white"><i class="fa fa-edit"></i> Edit User Data</button>
                                <button class="btn btn-sm btn-danger text-white"><i class="fa fa-ban"></i> Disable User</button>
                                <button class="btn btn-sm btn-primary text-white"><i class="fa fa-check"></i> Activate User</button>
                                <button class="btn btn-sm btn-info text-white"><i class="fa fa-arrow-up"></i>/<i class="fa fa-arrow-down"></i> Change User Level</button>
                                <button class="btn btn-sm btn-warning text-white"><i class="fa fa-refresh"></i> Change User Password to default</button>
                            </div>
                        </div>
                    </div>{{-- Legendary --}}
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
            { data: 'status' },
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
                targets: [6],
                render: function(data, type, row) {
                    var id = "'"+data.id+"'";
                    var name = "'"+data.name+"'";
                    var username = "'"+data.username+"'";
                    var level = data.level;
                    var status = data.status;
                    return generateButton(id, name, username, level, status);
                }
            }
        ],
        pageLength: 5,
        aLengthMenu:[5,10,15,25,50],
        order: [[5, 'asc'], [4, 'asc'], [1, 'asc']],
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
    function generateButton(id, name, username, level, status){
        var edit = '<a class="btn btn-warning text-white" onclick="formUpdate('+id+','+name+','+username+')"></i><i class="fa fa-edit"></i></a>';
        if(status == "Aktif"){
            var hapus = '<a class="btn btn-danger text-white" onclick="formDelete('+id+')"><i class="fa fa-ban"></i></a>';
            if(level == "Admin"){
                var permintaan = "'downgrade'";
                var ubahLevel = '<a class="btn btn-info text-white" onclick="formLevel('+id+', '+permintaan+')"><i class="fa fa-arrow-down"></i></a>';
            } else {
                var permintaan = "'upgrade'";
                var ubahLevel = '<a class="btn btn-info text-white" onclick="formLevel('+id+', '+permintaan+')"><i class="fa fa-arrow-up"></i></a>';
            }
            var resetPass = '<a class="btn btn-warning text-white" onclick="formResetPass('+id+')"><i class="fa fa-refresh"></i></a>';
        } else {
            var hapus = '<a class="btn btn-primary text-white" onclick="formActive('+id+')"><i class="fa fa-check"></i></a>';
            var ubahLevel = "";
            var resetPass = "";

        }

        return "<div class='btn-group'>"+edit+hapus+ubahLevel+resetPass+"</div>";
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
            var url_link = "{{ url('/staff/karyawan') }}/"+$("#user_id").val();
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
                $("#karyawanTable").DataTable().ajax.reload(null, false);
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
    function formUpdate(id, name, username){
        $("#span_title").text(" Form Karyawan (Update)");
        $("#request").val('update');
        $("#_method").val('PUT');
        $("#user_id").val(id);

        //Disable some field
        $("#input-email").prop('disabled', true);
        $("#input-password").prop('disabled', true);
        $("#input-password_confirmation").prop('disabled', true);

        //Set value
        $("#input-name").val(name);
        $("#input-username").val(username);
    }
    function formDelete(id){
        var user_id = id;
        var url_link = '{{ url('staff/karyawan') }}/'+user_id;

        swal({
            title: "Warning!",
            text: "This user status will set to Tidak Aktif so he/she cannot login to system, Are you sure?",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        }).then((value) => {
            if (value) {
                $.ajax({
                    method: 'POST',
                    url: url_link,
                    data: {'_method': 'delete', 'permintaan': 'hapus'},
                    cache: false,
                    success: function(result){
                        console.log(result);
                        //Re-Draw dataTable
                        $("#karyawanTable").DataTable().ajax.reload(null, false);
                        //Show alert
                        topright_notify(result.message);
                    },
                    error: function( jqXHR, textStatus, errorThrown ) {
                        console.log(jqXHR);
                    }
                });
            }
        });
    }
    function formLevel(id, permintaan){
        var user_id = id;
        var url_link = '{{ url('staff/karyawan') }}/'+user_id;

        if(permintaan == "upgrade"){
            var requestLevel = "Admin";
        } else {
            var requestLevel = "Karyawan";
        }

        swal({
            title: "Warning!",
            text: "Are you sure to change this user level to "+requestLevel+"?",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        }).then((value) => {
            if (value) {
                $.ajax({
                    method: 'POST',
                    url: url_link,
                    data: {'_method': 'delete', 'permintaan': permintaan},
                    cache: false,
                    success: function(result){
                        console.log(result);
                        //Re-Draw dataTable
                        $("#karyawanTable").DataTable().ajax.reload(null, false);
                        //Show alert
                        topright_notify(result.message);
                    },
                    error: function( jqXHR, textStatus, errorThrown ) {
                        console.log(jqXHR);
                    }
                });
            }
        });
    }
    function formResetPass(id){
        var user_id = id;
        var url_link = '{{ url('staff/karyawan') }}/'+user_id;

        swal({
            title: "Warning!",
            text: "Are you sure to change this user password? type 'reset' in input below to process",
            content: "input",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        }).then((value) => {
            if(value == "reset"){
                $.ajax({
                    method: 'POST',
                    url: url_link,
                    data: {'_method': 'delete', 'permintaan': 'reset'},
                    cache: false,
                    success: function(result){
                        console.log(result);
                        //Re-Draw dataTable
                        $("#karyawanTable").DataTable().ajax.reload(null, false);
                        //Show alert
                        topright_notify(result.message);
                    },
                    error: function( jqXHR, textStatus, errorThrown ) {
                        console.log(jqXHR);
                    }
                });
            } else {
                swal({
                    icon: "error",
                    title: "Failed!",
                    text: "Invalid, please try again. Please type 'reset' to start the process.",
                });
            }
        });
    }
    function formActive(id){
        var user_id = id;
        var url_link = '{{ url('staff/karyawan') }}/'+user_id;

        swal({
            title: "Warning!",
            text: "This user status will set to Aktif so he/she can login to system, Are you sure?",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        }).then((value) => {
            if (value) {
                $.ajax({
                    method: 'POST',
                    url: url_link,
                    data: {'_method': 'delete', 'permintaan': 'active'},
                    cache: false,
                    success: function(result){
                        console.log(result);
                        //Re-Draw dataTable
                        $("#karyawanTable").DataTable().ajax.reload(null, false);
                        //Show alert
                        topright_notify(result.message);
                    },
                    error: function( jqXHR, textStatus, errorThrown ) {
                        console.log(jqXHR);
                    }
                });
            }
        });
    }
    $("#formReset").click(function(e){ //Prevent default Action for Form
        e.preventDefault();
        formReset();
    });
    function formReset(){
        $(".error-block").remove();
        $(".form-control").removeClass('has-error');
        $(".input-group-text").removeClass('has-error');

        $("#span_title").text('Form Karyawan (Insert)');
        $("#request").val('insert');
        $("#_method").val('POST');
        $("#user_id").val('');

        //Enable some field
        $("#input-email").prop('disabled', false);
        $("#input-password").prop('disabled', false);
        $("#input-password_confirmation").prop('disabled', false);

        //Set value
        $("#input-name").val('');
        $("#input-username").val('');
    }
</script>
@endsection
