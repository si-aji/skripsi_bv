@extends('layouts.staff')

{{--  Require CSS for this Page  --}}
@section('plugin_css')
    <link href="{{ asset('plugins/dataTables/datatables.css') }}" rel="stylesheet">

    <link href="{{ asset('plugins/iCheck/all.css') }}" rel="stylesheet">{{-- iCheck --}}
@endsection

{{-- Content Header --}}
@section('staff_content_title')
    <h1 class="m-0 text-dark">Toko</h1>
@endsection
@section('staff_content_breadcrumb')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="{{ url('/staff') }}">Home</a></li>
        <li class="breadcrumb-item active">Toko</li>
    </ol>
@endsection{{-- Content Header --}}

@section('staff_content')
    <div class="row">
        <div class="col-12 col-lg-4">{{-- Form Toko --}}
            <div class="card">
                <div class="card-header no-border">
                    <h3 class="card-title"><i class="fa fa-home"></i> <span id="span_title">Form Toko (Insert)</span></h3>
                </div>
                <form role="form" id="tokoForm">
                    <div class="card-body">
                        <input type="hidden" name="request" id="request" value="insert">
                        <input type="hidden" name="_method" id="_method" value="POST">
                        <input type="hidden" name="id" id="toko_id">

                        <div class="form-group" id="field-toko_tipe">{{-- Toko Tipe --}}
                            <label for="input-toko_tipe">Tipe Toko</label>
                            <div class="row">
                                <div class="col-6">
                                    <label class="form-check-label">
                                        <input type="radio" class="minimal" name="toko_tipe" id="tipe_offline" value="Offline"> Offline
                                    </label>
                                </div>
                                <div class="col-6">
                                    <label class="form-check-label">
                                        <input type="radio" class="minimal" name="toko_tipe" id="tipe_online" value="Online"> Online
                                    </label>
                                </div>
                            </div>
                        </div>{{-- /.Toko Tipe --}}

                        <div class="form-group" id="field-toko_nama">{{-- Nama Toko --}}
                            <label for="input-toko_nama">Nama Toko</label>
                            <input type="text" name="toko_nama" class="form-control" placeholder="Nama Toko" id="input-toko_nama">
                        </div>{{-- /.Nama Toko --}}

                        <div class="form-group" id="field-toko_alamat">{{-- Alamat Toko --}}
                            <label for="input-toko_alamat">Alamat</label>
                            <input type="text" name="toko_alamat" class="form-control" placeholder="Alamat Toko" id="input-toko_alamat">
                        </div>{{-- /.Alamat Toko --}}

                        <div class="form-group" id="field-toko_link">{{-- Link Toko --}}
                            <label for="input-toko_link">Link</label>
                            <input type="text" name="toko_link" class="form-control" placeholder="Link Toko (GMaps, Link Online Store, etc)" id="input-toko_link">
                        </div>{{-- /.Link Toko --}}

                        <div class="form-group" id="field-toko_kontak">{{-- Kontak Toko --}}
                            <label for="input-toko_kontak">Kontak</label>
                            <input type="text" name="toko_kontak" class="form-control" placeholder="Kontak Toko" id="input-toko_kontak">
                        </div>{{-- /.Kontak Toko --}}
                    </div>

                    <div class="card-footer">
                        <div class="form-group text-right">
                            <button type="reset" id="formReset" class="btn btn-danger text-white">Reset</button>
                            <button type="submit" class="btn btn-primary text-white">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>{{-- /.Form Toko --}}
        <div class="col-12 col-lg-8">{{-- DataTable Toko --}}
            <div class="card">
                <div class="card-header no-border">
                    <h3 class="card-title"><span><i class="fa fa-tags"></i> List Toko</span></h3>
                </div>
                <div class="card-body">
                    <table class="table table-hover table-striped table-bordered" id="tokoTable">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th class="all">Nama</th>
                                <th class="all">Tipe</th>
                                <th class="desktop">Alamat</th>
                                <th class="desktop">Kontak</th>
                                <th class="desktop">Aksi</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>{{-- /.DataTable Toko --}}
    </div>
@endsection

{{--  Require Js for this page  --}}
@section('plugins_js')
    <script src="{{ asset('plugins/dataTables/datatables.js') }}"></script>
    <script src="{{ asset('plugins/dataTables/Responsive-2.2.1/js/datatables.responsive.js') }}"></script>

    <script src="{{ asset('plugins/iCheck/icheck.js') }}"></script>{{-- iCheck --}}
@endsection

@section('inline_js')
<script>
    $(document).ready(function(){
        document.title = "BakulVisor | Toko";
        $("#mn-toko").addClass('active');

        //Set for iCheck
        $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
            checkboxClass: 'icheckbox_minimal-blue',
            radioClass   : 'iradio_minimal-blue'
        });
        $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
            checkboxClass: 'icheckbox_flat-blue',
            radioClass   : 'iradio_flat-blue'
        });
    });

    var ttoko = $("#tokoTable").DataTable({
        responsive: true,
        processing: true,
        autoWidth: true,
        ajax: {
            method: "GET",
            url: "{{ url('list/toko') }}",
        },
        columns: [
            { data: null },
            { data: 'toko_nama' },
            { data: 'toko_tipe' },
            { data: null },
            { data: 'toko_kontak' },
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
                    if((data.toko_link != "" && data.toko_link != null && data.toko_link != "null") && (data.toko_alamat != "" && data.toko_alamat != null && data.toko_alamat != "null")){
                        return "<a href='"+data.toko_link+"'>"+data.toko_alamat+"</a>";
                    } else {
                        if(data.toko_alamat != "" && data.toko_alamat != null && data.toko_alamat != "null"){
                            return data.toko_alamat;
                        } else if(data.toko_link != "" && data.toko_link != null && data.toko_link != "null"){
                            return "<a href='"+data.toko_link+"'>"+data.toko_link+"</a>";
                        } else {
                            return "-";
                        }
                    }

                }
            }, {
                targets: [5],
                render: function(data, type, row) {
                    var id = "'"+data.id+"'";
                    var tipe = "'"+data.toko_tipe+"'";
                    var nama = "'"+data.toko_nama+"'";
                    var alamat = "'"+data.toko_alamat+"'";
                    var link = "'"+data.toko_link+"'";
                    var kontak = "'"+data.toko_kontak+"'";
                    return generateButton(id, tipe, nama, alamat, link, kontak);
                }
            }
        ],
        pageLength: 10,
        aLengthMenu:[5,10,15,25,50],
        order: [2, 'asc'],
        responsive: {
            details: {
                type: 'column',
                target: 'tr'
            }
        }
    });
    ttoko.on( 'order.dt search.dt', function () {
        ttoko.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
            cell.innerHTML = i+1;
        } );
    }).draw();
    function generateButton(id, tipe, nama, alamat, link, kontak){
        var edit = '<a class="btn btn-warning text-white" onclick="formUpdate('+id+','+tipe+','+nama+', '+alamat+', '+link+', '+kontak+')"><i class="fa fa-edit"></i></a>';
        var hapus = '<a class="btn btn-danger text-white" onclick="formDelete('+id+')"><i class="fa fa-trash"></i></a>';

        return "<div class='btn-group'>"+edit+hapus+"</div>";
    }

    $("#tokoForm").submit(function(e){ //Prevent default Action for Form
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
            var url_link = "{{ url('/staff/toko') }}";
        } else {
            //Update
            var formMethod = $("#_method").val();
            var url_link = "{{ url('/staff/toko') }}/"+$("#toko_id").val();
        }

        $.ajax({
            method: formMethod,
            url: url_link,
            data: $("#tokoForm").serialize(),
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
    //Untuk Update
    function formUpdate(id, tipe, nama, alamat, link, kontak){
        $("#span_title").text(" Form Toko (Update)");
        $("#request").val('update');
        $("#_method").val('PUT');
        $("#toko_id").val(id);

        //Check if Null or not
        if(alamat == "null"){
            alamat = "";
        }
        if(link == "null"){
            link = "";
        }
        if(kontak == "null"){
            kontak = "";
        }

        if(tipe == "Online"){
            $("#tipe_offline").prop('checked', false);
            $("#tipe_offline").iCheck('update');
            $("#tipe_online").prop('checked', true);
            $("#tipe_online").iCheck('update');
        } else {
            $("#tipe_offline").prop('checked', true);
            $("#tipe_offline").iCheck('update');
            $("#tipe_online").prop('checked', false);
            $("#tipe_online").iCheck('update');
        }

        $("#input-toko_nama").val(nama);
        $("#input-toko_alamat").val(alamat);
        $("#input-toko_link").val(link);
        $("#input-toko_kontak").val(kontak);
    }
    //Form Hapus
    function formDelete(id){
        var toko_id = id;
        var url_link = '{{ url('staff/toko') }}/'+toko_id;

        swal({
            title: "Warning!",
            text: "This data will be deleted, this action cannot be undo!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        }).then((value) => {
            if (value) {
                $.ajax({
                    method: 'POST',
                    url: url_link,
                    data: {'_method': 'delete'},
                    cache: false,
                    success: function(result){
                        console.log(result);
                        //Re-Draw dataTable
                        $("#tokoTable").DataTable().ajax.reload(null, false);
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
    //Form Reset
    function formReset(){
        $(".error-block").remove();
        $(".form-control").removeClass('has-error');
        $(".input-group-text").removeClass('has-error');

        $("#span_title").text(" Form Toko (Insert)");
        $("#request").val('insert');
        $("#_method").val('POST');
        $("#toko_id").val('');

        $("#tipe_offline").prop('checked', false);
        $("#tipe_offline").iCheck('update');
        $("#tipe_online").prop('checked', false);
        $("#tipe_online").iCheck('update');

        $("#input-toko_nama").val('');
        $("#input-toko_alamat").val('');
        $("#input-toko_link").val('');
        $("#input-toko_kontak").val('');
    }
</script>
@endsection
