@extends('layouts.staff')

{{--  Require CSS for this Page  --}}
@section('plugin_css')
    <link href="{{ asset('plugins/dataTables/datatables.css') }}" rel="stylesheet">

    <link href="{{ asset('plugins/iCheck/all.css') }}" rel="stylesheet">{{-- iCheck --}}
    <link href="{{ asset('plugins/select2/select2.css') }}" rel="stylesheet">{{-- Select2 --}}
@endsection

{{-- Content Header --}}
@section('staff_content_title')
    <h1 class="m-0 text-dark">Barang</h1>
@endsection
@section('staff_content_breadcrumb')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="{{ url('/staff') }}">Home</a></li>
        <li class="breadcrumb-item active">Barang</li>
    </ol>
@endsection{{-- Content Header --}}

@section('staff_content')
    <div class="row">
        <div class="col-12 col-lg-4">{{-- Form Barang --}}
            <div class="card">
                <div class="card-header no-border">
                    <h3 class="card-title"><i class="fa fa-th"></i> <span id="span_title">Form Barang (Insert)</span></h3>
                </div>

                <form role="form" id="barangForm">
                    <div class="card-body">
                        <input type="hidden" name="request" id="request" value="insert">
                        <input type="hidden" name="_method" id="_method" value="POST">
                        <input type="hidden" name="id" id="barang_id">

                        <div class="form-group" id="field-kategori_id">{{-- Kategori --}}
                            <label for="input-kategori_id">Kategori</label>
                            <div class="row">
                                <div class="col-9 col-md-10">
                                    <select name="kategori_id" class="form-control select2" id="input-kategori_id" onchange="setBarangKode()"></select>
                                    <input type="hidden" name="old_kategori_id" class="form-control" id="input-old_kategori_id" readonly>
                                </div>
                                <div class="col-3 col-md-2">
                                    <a data-toggle="modal" data-target="#modalKategori" class="btn btn-primary text-white w-100"><i class="fa fa-plus"></i></a>
                                </div>
                            </div>
                        </div>{{-- /.Kategori --}}

                        <div class="form-group" id="field-barang_kode">{{-- Barang Kode --}}
                            <label for="input-barang_kode">Kode Barang</label>
                            <div class="row">
                                <div class="col-6">
                                    <input type="text" name="kategori_kode" class="form-control" placeholder="Kode Kategori" id="input-kategori_kode" readonly>
                                </div>
                                <div class="col-6">
                                    <input type="text" name="barang_kode" class="form-control" placeholder="Kode Barang" id="input-barang_kode" readonly>
                                    <input type="hidden" name="old_barang_kode" class="form-control" placeholder="Kode Barang" id="input-old_barang_kode" readonly>
                                </div>
                            </div>
                            <label class="text-muted mb-0"><small>Example : VS-1 (VS is Kategori code and 1 is Product code)</small></label>
                        </div>{{-- /.Barang Kode --}}

                        <div class="form-group" id="field-barang_nama">{{-- Barang Nama --}}
                            <label for="input-barang_nama">Nama Barang</label>
                            <input type="text" name="barang_nama" class="form-control" placeholder="Nama Barang" id="input-barang_nama">
                        </div>{{-- /.Barang Nama --}}

                        <div class="row">{{-- Harga Barang --}}
                            <div class="col-12 col-md-6">{{-- Harga Beli --}}
                                <div class="form-group" id="field-barang_hBeli">
                                    <label for="input-barang_hBeli">Harga Beli@</label>
                                    <input type="number" min="0" value="0" name="barang_hBeli" class="form-control" placeholder="0" id="input-barang_hBeli">
                                </div>
                            </div>{{-- /.Harga Beli --}}
                            <div class="col-12 col-md-6">{{-- Harga Jual --}}
                                <div class="form-group" id="field-barang_hJual">
                                    <label for="input-barang_hJual">Harga Jual@</label>
                                    <input type="number" min="0" value="0" name="barang_hJual" class="form-control" placeholder="0" id="input-barang_hJual">
                                </div>
                            </div>{{-- /.Harga Jual --}}
                        </div>{{-- /.Harga Barang --}}

                        <div class="form-group" id="field-barang_stokStatus">{{-- Stok --}}
                            <label for="input-barang_stok">Stok Barang</label>
                            <div class="input-group">
                                <div class="input-group-prepend">{{-- Status Stok --}}
                                    <span class="input-group-text">
                                        <input type="checkbox" name="check-barang_stokStatus" id="check-barang_stokStatus" class="flat-red" value="Aktif">
                                    </span>
                                </div>
                                <input type="text" class="form-control" name="barang_stokStatus" id="input-barang_stokStatus" value="Tidak Aktif" readonly>{{-- /.Status Stok --}}
                                <input type="number" class="form-control" id="input-barang_stok" name="barang_stok" min="0" value="0" readonly>
                            </div>
                        </div>{{-- /.Stok --}}

                        <div class="form-group" id="field-barang_detail">
                            <label for="input-barang_detail">Detail</label>
                            <textarea placeholder="Detail Barang" class="form-control" id="input-barang_detail" name="barang_detail"></textarea>
                        </div>
                    </div>

                    <div class="card-footer">
                        <div class="form-group text-right">
                            <button type="reset" id="formReset" class="btn btn-danger text-white">Reset</button>
                            <button type="submit" class="btn btn-primary text-white">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>{{-- /.Form Barang --}}
        <div class="col-12 col-lg-8">{{-- DataTable Barang --}}
            <div class="card">
                <div class="card-header no-border">
                    <h3 class="card-title"><span><i class="fa fa-th"></i> List Barang</span></h3>
                </div>
                <div class="card-body">
                    <table class="table table-hover table-striped table-bordered" id="barangTable">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th class="desktop">Kode</th>
                                <th class="desktop">ID</th>
                                <th class="all">Nama Barang</th>
                                <th class="desktop">Harga Beli</th>
                                <th class="desktop">Harga Jual</th>
                                <th class="all">Stok</th>
                                <th class="desktop">Aksi</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>{{-- /.DataTable Barang --}}
    </div>

    {{--  Modal for Kategori  --}}
    <div class="modal fade" id="modalKategori" tabindex="-1" role="dialog" aria-labelledby="labelKategori" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="labelKategori">Form Tambah Kategori</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form role="form" id="kategoriForm">{{-- Form Start --}}
                        <div class="form-group" id="field-kategori_kd">{{-- Kode Kategori --}}
                            <input type="text" name="kategori_kode" class="form-control" placeholder="Kode Kategori" id="input-kategori_kd">
                            <label class="text-muted mb-0"><small>Max 10 Character. Example : HE for Helm</small></label>
                        </div>{{-- /.Kode Kategori --}}

                        <div class="form-group" id="field-kategori_nama">{{-- Nama Kategori --}}
                            <input type="text" name="kategori_nama" class="form-control" placeholder="Nama Kategori" id="input-kategori_nama">
                        </div>{{-- /.Nama Kategori --}}

                        <div class="form-group text-right">
                            <button type="reset" id="kategoriReset" class="btn btn-danger text-white">Reset</button>
                            <button type="submit" class="btn btn-primary text-white">Submit</button>
                        </div>
                    </form>{{-- Form Start --}}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    {{--  /.Modal for Kategori  --}}
@endsection

{{--  Require Js for this page  --}}
@section('plugins_js')
    <script src="{{ asset('plugins/dataTables/datatables.js') }}"></script>
    <script src="{{ asset('plugins/dataTables/Responsive-2.2.1/js/datatables.responsive.js') }}"></script>

    <script src="{{ asset('plugins/iCheck/icheck.js') }}"></script>{{-- iCheck --}}
    <script src="{{ asset('plugins/select2/select2.js') }}"></script>{{-- select2 --}}
    <script src="https://cdn.ckeditor.com/ckeditor5/11.0.1/classic/ckeditor.js"></script>{{-- ckeditor 5 --}}
@endsection

@section('inline_js')
<script>
    //Set ckeditor
    ClassicEditor.create(
        document.querySelector( '#input-barang_detail' ), {
            removePlugins: [ "Image", "ImageCaption", "ImageStyle", "ImageToolbar", "ImageUpload" ]
        }
    ).then(
        newEditor => {ckeditor = newEditor;}
    ).catch(
        error => {console.error( error );}
    );

    $(document).ready(function(){
        document.title = "BakulVisor | Barang";
        $("#mn-barang").addClass('active');

        //Set for select2
        $('.select2').select2();
        //Set kategori for select2
        loadKategoriData();

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

    var tbarang = $("#barangTable").DataTable({
        responsive: true,
        processing: true,
        autoWidth: true,
        ajax: {
            method: "GET",
            url: "{{ url('list/barang') }}",
        },
        columns: [
            { data: null },
            { data: null },
            { data: null },
            { data: 'barang_nama' },
            { data: null },
            { data: null },
            { data: null },
            { data: null },
        ],
        columnDefs: [
            {
                targets: [0],
                searchable: false,
                orderable: false,
            }, {
                targets: [1],
                render: function(data, type, row) {
                    return data.kategori['kategori_kode'];
                }
            },
            {
                targets: [2],
                render: function(data, type, row) {
                    return data['barang_kode'];
                }
            },{
                targets: [4],
                render: function(data, type, row) {
                    var angka = parseInt(data['barang_hBeli']);
                    return idr_curr(angka);
                }
            }, {
                targets: [5],
                render: function(data, type, row) {
                    var angka = parseInt(data['barang_hJual']);
                    return idr_curr(angka);
                }
            }, {
                targets: [6],
                render: function(data, type, row) {
                    if(data['barang_stokStatus'] == "Aktif"){
                        return data['barang_stok'];
                    } else {
                        return "-";
                    }
                }
            }, {
                targets: [7],
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
    tbarang.on( 'order.dt search.dt', function () {
        tbarang.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
            cell.innerHTML = i+1;
        } );
    }).draw();
    function generateButton(id){
        var edit = '<a class="btn btn-warning text-white" onclick="formUpdate('+id+')"><i class="fa fa-edit"></i></a>';
        var hapus = '<a class="btn btn-danger text-white" onclick="formDelete('+id+')"><i class="fa fa-trash"></i></a>';

        return "<div class='btn-group'>"+edit+hapus+"</div>";
    }

    {{-- Function for Kategori --}}
    function loadKategoriData(){
        //Untuk mendapatkan data kategori
        $.ajax({
            method: "GET",
            url: "{{ url('/list/kategori') }}",
            cache: false,
            success: function(result){
                //console.log(result);

                if(result != null && $("#input-kategori_id").children('option').length){
                    //console.log("Select2 terisi");
                    $.each(result.data, function(key, result){
                        //console.log("Result : "+JSON.stringify(result));
                        var selectData = {
                            id: result['id'],
                            text: "("+result['kategori_kode']+") "+result['kategori_nama']
                        };

                        //Cek apakah opsi sudah ada di select2
                        if(!$('#input-kategori_id').find("option[value='" + result['id'] + "']").length){
                            //console.log(result['kategori_nama']+" belum ada");
                            var newOption = new Option(selectData.text, selectData.id, true, true);
                            $('#input-kategori_id').append(newOption).trigger('change');
                        }
                    });
                } else {
                    //console.log("Select2 kosong");
                    $.each(result.data, function(key, result){
                        //console.log("Result : "+JSON.stringify(result));
                        var selectData = {
                            id: result['id'],
                            text: "("+result['kategori_kode']+") "+result['kategori_nama']
                        };
                        var newOption = new Option(selectData.text, selectData.id, false, false);
                        $('#input-kategori_id').append(newOption).trigger('change');
                    });
                }
            }
        });
    }

    $("#kategoriForm").submit(function(e){ //Prevent default Action for Form
        e.preventDefault();
        kategoriAction();
    });
    function kategoriAction(){
        //console.log("Running Kategori");
        //Remove All Errors block that exists
        $(".error-block").remove();
        $(".form-control").removeClass('has-error');
        $(".input-group-text").removeClass('has-error');

        $.ajax({
            method: "POST",
            url: "{{ url('/staff/kategori') }}",
            data: $("#kategoriForm").serialize(),
            cache: false,
            success: function(result){
                //console.log(result);
                $('#modalKategori').modal('hide');
                loadKategoriData();

                //Show alert
                topright_notify(result.message);
                //ResetForm
                kategoriReset();
            },
            error: function( jqXHR, textStatus, errorThrown ) {
                //console.log(jqXHR);

                //Print all error message
                $.each(jqXHR.responseJSON.errors, function(key, result) {

                    if(key == "kategori_kode"){
                        var field_id = "field-kategori_kd";
                        var input_id = "input-kategori_kd";
                        var input_group_id = "input_group-kategori_kd";
                    } else {
                        var field_id = "field-"+key;
                        var input_id = "input-"+key;
                        var input_group_id = "input_group-"+key;
                    }
                    //Append Error Field
                    $("#"+input_id).addClass('has-error');
                    $("#"+input_group_id).addClass('has-error');
                    //Append Error Message
                    $("#"+field_id).append("<div class='text-muted error-block'><span class='help-block'><small>"+result+"</small></span></div>");
                });
            }
        });
    }
    $("#kategoriReset").click(function(e){ //Prevent default Action for Form
        e.preventDefault();
        kategoriReset();
    });
    function kategoriReset(){
        $(".error-block").remove();
        $(".form-control").removeClass('has-error');
        $(".input-group-text").removeClass('has-error');

        $("#input-kategori_kd").val('');
        $("#input-kategori_nama").val('');
    }
    {{-- Function for Kategori --}}

    {{-- Function for Stok --}}
    $("#check-barang_stokStatus").on('ifChecked', function(){
        stockActive();
    });
    $("#check-barang_stokStatus").on('ifUnchecked', function(){
        stockUnActive();
    });
    function stockActive(){
        //console.log("Stok Aktif");
        $("#input-barang_stokStatus").val('Aktif');
        $("#input-barang_stok").attr('readonly', false);
    }
    function stockUnActive(){
        //console.log("Stok Tidak Aktif");
        $("#input-barang_stokStatus").val('Tidak Aktif');
        $("#input-barang_stok").val('0').attr('readonly', true);
    }
    {{-- /.Function for Stok --}}

    {{--  Function for Kode Barang  --}}
    function setBarangKode(){
        $("#input-kategori_kode").val($("#input-kategori_id option:selected").text());

        $.ajax({
            method: "GET",
            url: "{{ url('data/barang/kategori') }}/"+$("#input-kategori_id").val(),
            data : {'kategori_id': $("#input-kategori_id").val()},
            cache: false,
            success: function(result){
                //console.log(result);

                if(jQuery.isEmptyObject(result)){
                    //console.log("Belum ada data");
                    $("#input-barang_kode").val('1');
                } else {
                    if($("#input-kategori_id").val() != $("#input-old_kategori_id").val()){
                        $("#input-barang_kode").val(parseInt(result)+1);
                    } else {
                        $("#input-barang_kode").val($("#input-old_barang_kode").val());
                    }
                }
            }
        });
    }
    {{--  /.Function for Kode Barang  --}}

    {{-- Function for Form --}}
    $("#barangForm").submit(function(e){ //Prevent default Action for Form
        e.preventDefault();
        formAction();
    });
    function formAction(){
        $("#input-barang_detail").val(editorData = ckeditor.getData());
        //Remove All Errors block that exists
        $(".error-block").remove();
        $(".form-control").removeClass('has-error');
        $(".input-group-text").removeClass('has-error');

        if($("#request").val() == "insert"){
            //Insert
            var formMethod = $("#_method").val();
            var url_link = "{{ url('/staff/barang') }}";
        } else {
            //Update
            var formMethod = $("#_method").val();
            var url_link = "{{ url('/staff/barang') }}/"+$("#barang_id").val();
        }

        $.ajax({
            method: formMethod,
            url: url_link,
            data: $("#barangForm").serialize(),
            cache: false,
            success: function(result){
                console.log(result);

                //Show alert
                topright_notify(result.message);
                //Re-Draw dataTable
                $("#barangTable").DataTable().ajax.reload(null, false);
                //ResetForm
                formReset();
            },
            error: function( jqXHR, textStatus, errorThrown ) {
                ///console.log(jqXHR);

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
    //Untuk Reset
    $("#formReset").click(function(e){ //Prevent default Action for Form
        e.preventDefault();
        formReset();
    });
    function formReset(){
        $("#span_title").text('Form Barang (Insert)');
        $("#request").val('insert');
        $("#_method").val('POST');
        $("#barang_id").val('');

        $("#input-old_barang_kode").val('');
        $("#input-barang_nama").val('');
        $("#input-barang_hBeli").val('0');
        $("#input-barang_hJual").val('0');

        $("#check-barang_stokStatus").iCheck('uncheck');
        stockUnActive();

        $("#input-barang_detail").val(editorData = ckeditor.setData(' '));

        $("#input-old_kategori_id").val('');
        $("#input-kategori_id").prop('selectedIndex', '0').change();
    }
    //Untuk Update
    function formUpdate(id){
        $.ajax({
            method: "GET",
            url: "{{ url('/data/barang/') }}/"+id,
            success: function(result){
                //console.log(result.data[0].kategori['kategori_kode']);

                $("#span_title").text('Form Barang (Update)');
                $("#request").val('update');
                $("#_method").val('PUT');
                $("#barang_id").val(id);

                $("#input-kategori_kode").val(result.data[0].kategori['kategori_kode']);
                $("#input-barang_kode").val(result.data[0]['barang_kode']);
                $("#input-old_barang_kode").val(result.data[0]['barang_kode']);
                $("#input-barang_nama").val(result.data[0]['barang_nama']);
                $("#input-barang_hBeli").val(result.data[0]['barang_hBeli']);
                $("#input-barang_hJual").val(result.data[0]['barang_hJual']);

                if(result.data[0]['barang_stokStatus'] == "Aktif"){
                    $("#check-barang_stokStatus").iCheck('check');
                    stockActive();
                    $("#input-barang_stok").val(result.data[0]['barang_stok']);
                } else {
                    $("#check-barang_stokStatus").iCheck('uncheck');
                    stockUnActive();
                }


                if(result.data[0]['barang_detail'] != "null"){
                    $("#input-barang_detail").val(editorData = ckeditor.setData(unescapeHtml(result.data[0]['barang_detail'])));
                    //console.log("Detail : "+unescapeHtml(result.data[0]['barang_detail']));
                }

                $("#input-kategori_id").val(result.data[0]['kategori_id']);
                $("#input-old_kategori_id").val(result.data[0]['kategori_id']);
                $('#input-kategori_id').trigger('change');
            }
        });
    }
    //Untuk hapus
    function formDelete(id){
        var barang_id = id;
        var url_link = '{{ url('staff/barang') }}/'+barang_id;

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
                        $("#barangTable").DataTable().ajax.reload(null, false);
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
    {{-- /.Function for Form --}}
</script>
@endsection
