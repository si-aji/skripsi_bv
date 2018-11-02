@extends('layouts.staff')

{{--  Require CSS for this Page  --}}
@section('plugin_css')
    <link href="{{ asset('plugins/dataTables/datatables.css') }}" rel="stylesheet">
@endsection

{{-- Content Header --}}
@section('staff_content_title')
    <h1 class="m-0 text-dark">Supplier</h1>
@endsection
@section('staff_content_breadcrumb')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="{{ url('/staff') }}">Home</a></li>
        <li class="breadcrumb-item active">Supplier</li>
    </ol>
@endsection{{-- Content Header --}}

@section('staff_content')
    <div class="row">
        <div class="col-12 col-lg-4">{{-- Form Supplier --}}
            <div class="card">
                <div class="card-header no-border">
                    <h3 class="card-title"><i class="fa fa-truck"></i> <span id="span_title">Form Supplier (Insert)</span></h3>
                </div>

                <form role="form" id="supplierForm">
                    <div class="card-body">
                        <input type="hidden" name="request" id="request" value="insert">
                        <input type="hidden" name="_method" id="_method" value="POST">
                        <input type="hidden" name="id" id="supplier_id">

                        <div class="form-group" id="field-supplier_nama">{{-- Supplier Nama --}}
                            <label for="input-supplier_nama">Nama Supplier</label>
                            <input type="text" name="supplier_nama" class="form-control" placeholder="Nama supplier" id="input-supplier_nama">
                        </div>{{-- /.Supplier Nama --}}

                        <div class="form-group" id="field-supplier_kontak">{{-- Supplier Kontak --}}
                            <label for="input-supplier_kontak">Kontak</label>
                            <input type="text" name="supplier_kontak" class="form-control" placeholder="Kontak (Line, WA, Instagram, dll)" id="input-supplier_kontak">
                        </div>{{-- /.Supplier Kontak --}}

                        <div class="form-group" id="field-supplier_detail">{{-- Supplier Detail --}}
                            <label for="input-supplier_detail">Detail</label>
                            <input type="text" name="supplier_detail" class="form-control" placeholder="Detail (Catatan)" id="input-supplier_detail">
                        </div>{{-- /.Supplier Detail --}}
                    </div>

                    <div class="card-footer">
                        <div class="form-group text-right">
                            <button type="reset" id="formReset" class="btn btn-danger text-white">Reset</button>
                            <button type="submit" class="btn btn-primary text-white">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>{{-- /.Form Supplier --}}
        <div class="col-12 col-lg-8">{{-- DataTable Supplier --}}
            <div class="card">
                <div class="card-header no-border">
                    <h3 class="card-title"><span><i class="fa fa-truck"></i> List Supplier</span></h3>
                </div>
                <div class="card-body">
                    <table class="table table-hover table-striped table-bordered" id="supplierTable">
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
        </div>{{-- /.DataTable Supplier --}}
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
        document.title = "BakulVisor | Supplier";
        $("#mn-supplier").addClass('active');
    });

    var tsupplier = $("#supplierTable").DataTable({
        responsive: true,
        processing: true,
        autoWidth: true,
        ajax: {
            method: "GET",
            url: "{{ url('list/supplier') }}",
        },
        columns: [
            { data: null },
            { data: 'supplier_nama' },
            { data: 'supplier_kontak' },
            { data: 'supplier_detail' },
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
                    var nama = "'"+data.supplier_nama+"'";
                    var kontak = "'"+data.supplier_kontak+"'";
                    var detail = "'"+data.supplier_detail+"'";
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
    tsupplier.on( 'order.dt search.dt', function () {
        tsupplier.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
            cell.innerHTML = i+1;
        } );
    }).draw();
    function generateButton(id, nama, kontak, detail){
        var edit = '<a class="btn btn-warning text-white" onclick="formUpdate('+id+','+nama+','+kontak+','+detail+')"><i class="fa fa-edit"></i></a>';
        var hapus = '<a class="btn btn-danger text-white" onclick="formDelete('+id+')"><i class="fa fa-trash"></i></a>';

        return "<div class='btn-group'>"+edit+hapus+"</div>";
    }

    $("#supplierForm").submit(function(e){ //Prevent default Action for Form
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
            var url_link = "{{ url('/staff/supplier') }}";
        } else {
            //Update
            var formMethod = $("#_method").val();
            var url_link = "{{ url('/staff/supplier') }}/"+$("#supplier_id").val();
        }

        $.ajax({
            method: formMethod,
            url: url_link,
            data: $("#supplierForm").serialize(),
            cache: false,
            success: function(result){
                console.log(result);

                //Show alert
                topright_notify(result.message);
                //Re-Draw dataTable
                $("#supplierTable").DataTable().ajax.reload(null, false);
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
        $("#span_title").text(" Form Supplier (Update)");
        $("#request").val('update');
        $("#_method").val('PUT');
        $("#supplier_id").val(id);

        if(nama == "null"){
            nama = "";
        }
        if(kontak == "null"){
            kontak = "";
        }
        if(detail == "null"){
            detail = "";
        }

        $("#input-supplier_nama").val(nama);
        $("#input-supplier_kontak").val(kontak);
        $("#input-supplier_detail").val(detail);
    }
    function formDelete(id){
        var supplier_id = id;
        var url_link = '{{ url('staff/supplier') }}/'+supplier_id;

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
                        $("#supplierTable").DataTable().ajax.reload(null, false);
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

        $("#span_title").text('Form Barang (Insert)');
        $("#request").val('insert');
        $("#_method").val('POST');
        $("#supplier_id").val('');

        $("#input-supplier_nama").val('');
        $("#input-supplier_kontak").val('');
        $("#input-supplier_detail").val('');
    }
</script>
@endsection
