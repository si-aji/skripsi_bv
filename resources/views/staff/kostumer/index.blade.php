@extends('layouts.staff')

{{--  Require CSS for this Page  --}}
@section('plugin_css')
    <link href="{{ asset('plugins/dataTables/datatables.css') }}" rel="stylesheet">
@endsection

{{-- Content Header --}}
@section('staff_content_title')
    <h1 class="m-0 text-dark">Kostumer</h1>
@endsection
@section('staff_content_breadcrumb')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="{{ url('/staff') }}">Home</a></li>
        <li class="breadcrumb-item active">Kostumer</li>
    </ol>
@endsection{{-- Content Header --}}

@section('staff_content')
    <div class="row">
        <div class="col-12 col-lg-4">{{-- Form Kostumer --}}
            <div class="card">
                <div class="card-header no-border">
                    <h3 class="card-title"><i class="fa fa-users"></i> <span id="span_title">Form Kostumer (Insert)</span></h3>
                </div>

                <form role="form" id="kostumerForm">
                    <div class="card-body">
                        <input type="hidden" name="request" id="request" value="insert">
                        <input type="hidden" name="_method" id="_method" value="POST">
                        <input type="hidden" name="id" id="kostumer_id">

                        <div class="form-group" id="field-kostumer_nama">{{-- Kostumer Nama --}}
                            <label for="input-kostumer_nama">Nama Kostumer</label>
                            <input type="text" name="kostumer_nama" class="form-control" placeholder="Nama Kostumer" id="input-kostumer_nama">
                        </div>{{-- /.Kostumer Nama --}}

                        <div class="form-group" id="field-kostumer_kontak">{{-- Kostumer Kontak --}}
                            <label for="input-kostumer_kontak">Kontak</label>
                            <input type="text" name="kostumer_kontak" class="form-control" placeholder="Kontak (Line, WA, Instagram, dll)" id="input-kostumer_kontak">
                        </div>{{-- /.Kostumer Kontak --}}

                        <div class="form-group" id="field-kostumer_detail">{{-- Kostumer Detail --}}
                            <label for="input-kostumer_detail">Detail</label>
                            <input type="text" name="kostumer_detail" class="form-control" placeholder="Detail (Catatan)" id="input-kostumer_detail">
                        </div>{{-- /.Kostumer Detail --}}
                    </div>

                    <div class="card-footer">
                        <div class="form-group text-right">
                            <button type="reset" id="formReset" class="btn btn-danger text-white">Reset</button>
                            <button type="submit" class="btn btn-primary text-white">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>{{-- /.Form Kostumer --}}
        <div class="col-12 col-lg-8">{{-- DataTable Kostumer --}}
            <div class="card">
                <div class="card-header no-border">
                    <h3 class="card-title"><span><i class="fa fa-users"></i> List Kostumer</span></h3>
                </div>
                <div class="card-body">
                    <table class="table table-hover table-striped table-bordered" id="kostumerTable">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th class="all">Nama</th>
                                <th class="desktop">Kontak</th>
                                <th class="desktop">Detail</th>
                                <th class="desktop">Aksi</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>{{-- /.DataTable Kostumer --}}
    </div>
@endsection

{{--  Require Js for this page  --}}
@section('plugins_js')
    <script src="{{ asset('plugins/dataTables/datatables.js') }}"></script>
    <script src="{{ asset('plugins/dataTables/Responsive-2.2.1/js/dataTables.responsive.js') }}"></script>
@endsection

@section('inline_js')
<script>
    $(document).ready(function(){
        document.title = "BakulVisor | Kostumer";
        $("#mn-kostumer").addClass('active');
    });

    var tkostumer = $("#kostumerTable").DataTable({
        responsive: true,
        processing: true,
        autoWidth: true,
        ajax: {
            method: "GET",
            url: "{{ url('list/kostumer') }}",
        },
        columns: [
            { data: null },
            { data: 'kostumer_nama' },
            { data: 'kostumer_kontak' },
            { data: 'kostumer_detail' },
            { data: null },
        ],
        columnDefs: [
            {
                targets: [0],
                searchable: false,
                orderable: false,
            }, {
                targets: [4],
                render: function(data, type, row) {
                    var id = "'"+data.id+"'";
                    var nama = "'"+data.kostumer_nama+"'";
                    var kontak = "'"+data.kostumer_kontak+"'";
                    var detail = "'"+data.kostumer_detail+"'";
                    return generateButton(id, nama, kontak, detail);
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
    tkostumer.on( 'order.dt search.dt', function () {
        tkostumer.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
            cell.innerHTML = i+1;
        } );
    }).draw();
    function generateButton(id, nama, kontak, detail){
        var edit = '<a class="btn btn-warning text-white" onclick="formUpdate('+id+','+nama+','+kontak+','+detail+')"><i class="fa fa-edit"></i></a>';
        var hapus = '<a class="btn btn-danger text-white" onclick="formDelete('+id+')"><i class="fa fa-trash"></i></a>';

        return "<div class='btn-group'>"+edit+hapus+"</div>";
    }

    $("#kostumerForm").submit(function(e){ //Prevent default Action for Form
        e.preventDefault();
        formAction();
    });
    function formAction(){
        //console.log("Running Kategori");
        //Remove All Errors block that exists
        $(".error-block").remove();
        $(".form-control").removeClass('has-error');
        $(".input-group-text").removeClass('has-error');

        if($("#request").val() == "insert"){
            //Insert
            var formMethod = $("#_method").val();
            var url_link = "{{ url('/staff/kostumer') }}";
        } else {
            //Update
            var formMethod = $("#_method").val();
            var url_link = "{{ url('/staff/kostumer') }}/"+$("#kostumer_id").val();
        }

        $.ajax({
            method: formMethod,
            url: url_link,
            data: $("#kostumerForm").serialize(),
            cache: false,
            success: function(result){
                console.log(result);

                //Show alert
                topright_notify(result.message);
                //Re-Draw dataTable
                $("#kostumerTable").DataTable().ajax.reload(null, false);
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
    function formUpdate(id, nama, kontak, detail){
        $("#span_title").text(" Form Kostumer (Update)");
        $("#request").val('update');
        $("#_method").val('PUT');
        $("#kostumer_id").val(id);

        if(nama == "null"){
            nama = "";
        }
        if(kontak == "null"){
            kontak = "";
        }
        if(detail == "null"){
            detail = "";
        }

        $("#input-kostumer_nama").val(nama);
        $("#input-kostumer_kontak").val(kontak);
        $("#input-kostumer_detail").val(detail);
    }
    $("#formReset").click(function(e){ //Prevent default Action for Form
        e.preventDefault();
        formReset();
    });
    function formReset(){
        $(".error-block").remove();
        $(".form-control").removeClass('has-error');
        $(".input-group-text").removeClass('has-error');

        $("#span_title").text('Form Barang (Insert)');
        $("#request").val('insert');
        $("#_method").val('POST');
        $("#kostumer_id").val('');

        $("#input-kostumer_nama").val('');
        $("#input-kostumer_kontak").val('');
        $("#input-kostumer_detail").val('');
    }
</script>
@endsection
