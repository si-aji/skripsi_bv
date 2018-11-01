@extends('layouts.staff')

{{--  Require CSS for this Page  --}}
@section('plugin_css')
    <link href="{{ asset('plugins/dataTables/datatables.css') }}" rel="stylesheet">
@endsection

{{-- Content Header --}}
@section('staff_content_title')
    <h1 class="m-0 text-dark">Kategori</h1>
@endsection
@section('staff_content_breadcrumb')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="{{ url('/staff') }}">Home</a></li>
        <li class="breadcrumb-item active">Kategori</li>
    </ol>
@endsection{{-- Content Header --}}

@section('staff_content')
    <div class="row">
        <div class="col-12 col-lg-4">{{-- Form Kategori --}}
            <div class="card">
                <div class="card-header no-border">
                    <h3 class="card-title"><i class="fa fa-tags"></i> <span id="span_title">Form Kategori (Insert)</span></h3>
                </div>
                <form role="form" id="kategoriForm">
                    <div class="card-body">
                        <input type="hidden" name="request" id="request" value="insert">
                        <input type="hidden" name="_method" id="_method" value="POST">
                        <input type="hidden" name="id" id="kategori_id">

                        <div class="form-group" id="field-kategori_kode">{{-- Kode Kategori --}}
                            <input type="text" name="kategori_kode" class="form-control" placeholder="Kode Kategori" id="input-kategori_kode">
                            <label class="text-muted mb-0"><small>Max 10 Character. Example : HE for Helm</small></label>
                        </div>{{-- /.Kode Kategori --}}

                        <div class="form-group" id="field-kategori_nama">{{-- Nama Kategori --}}
                            <input type="text" name="kategori_nama" class="form-control" placeholder="Nama Kategori" id="input-kategori_nama">
                        </div>{{-- /.Nama Kategori --}}
                    </div>

                    <div class="card-footer">
                        <div class="form-group text-right">
                            <button type="reset" id="formReset" class="btn btn-danger text-white">Reset</button>
                            <button type="submit" class="btn btn-primary text-white">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>{{-- /.Form Kategori --}}
        <div class="col-12 col-lg-8">{{-- DataTable Kategori --}}
            <div class="card">
                <div class="card-header no-border">
                    <h3 class="card-title"><span><i class="fa fa-tags"></i> List Kategori</span></h3>
                </div>
                <div class="card-body">
                    <table class="table table-hover table-striped table-bordered" id="kategoriTable">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th class="desktop">Kode Kategori</th>
                                <th class="all">Nama Kategori</th>
                                <th class="desktop">Aksi</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>{{-- /.DataTable Kategori --}}
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
        document.title = "BakulVisor | Kategori";
        $("#mn-kategori").addClass('active');
    });

    var tkategori = $("#kategoriTable").DataTable({
        responsive: true,
        processing: true,
        autoWidth: true,
        ajax: {
            method: "GET",
            url: "{{ url('list/kategori') }}",
        },
        columns: [
            { data: null },
            { data: 'kategori_kode' },
            { data: 'kategori_nama' },
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
                    var id = "'"+data.id+"'";
                    var kode = "'"+data.kategori_kode+"'";
                    var nama = "'"+data.kategori_nama+"'";
                    return generateButton(id, kode, nama);
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
    tkategori.on( 'order.dt search.dt', function () {
        tkategori.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
            cell.innerHTML = i+1;
        } );
    }).draw();
    function generateButton(id, kode, nama){
        var edit = '<a class="btn btn-warning text-white" onclick="formUpdate('+id+','+kode+','+nama+')"><i class="fa fa-edit"></i></a>';
        var hapus = '<a class="btn btn-danger text-white" onclick="formDelete('+id+')"><i class="fa fa-trash"></i></a>';

        return "<div class='btn-group'>"+edit+hapus+"</div>";
    }

    $("#kategoriForm").submit(function(e){ //Prevent default Action for Form
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
            var url_link = "{{ url('/staff/kategori') }}";
        } else {
            //Update
            var formMethod = $("#_method").val();
            var url_link = "{{ url('/staff/kategori') }}/"+$("#kategori_id").val();
        }

        $.ajax({
            method: formMethod,
            url: url_link,
            data: $("#kategoriForm").serialize(),
            cache: false,
            success: function(result){
                console.log(result);

                //Show alert
                topright_notify(result.message);
                //Re-Draw dataTable
                $("#kategoriTable").DataTable().ajax.reload(null, false);
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
    //Form Hapus
    function formDelete(id){
        var kategori_id = id;
        var url_link = '{{ url('staff/kategori') }}/'+kategori_id;

        swal({
            title: "Warning!",
            text: "This data and product data related to this category will be deleted, this action cannot be undo!",
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
                        $("#kategoriTable").DataTable().ajax.reload(null, false);
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
    //Form Update
    function formUpdate(id, kode, nama){
        $("#span_title").text(" Form Kategori (Update)");
        $("#request").val('update');
        $("#_method").val('PUT');
        $("#kategori_id").val(id);

        $("#input-kategori_kode").val(kode);
        $("#input-kategori_nama").val(nama);
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

        $("#span_title").text(" Form Kategori (Insert)");
        $("#request").val('insert');
        $("#_method").val('POST');
        $("#kategori_id").val('');

        $("#input-kategori_kode").val('');
        $("#input-kategori_nama").val('');
    }
</script>
@endsection
