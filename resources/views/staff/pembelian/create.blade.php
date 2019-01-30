@extends('layouts.staff')

{{-- Content Header --}}
@section('staff_content_title')
    <h1 class="m-0 text-dark">(Tambah) Pembelian</h1>
@endsection
@section('staff_content_breadcrumb')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="{{ url('/staff') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ url('/staff/pembelian') }}">Pembelian</a></li>
        <li class="breadcrumb-item active">Tambah</li>
    </ol>
@endsection{{-- Content Header --}}

{{--  Require CSS for this Page  --}}
@section('plugin_css')
    <link href="{{ asset('plugins/select2/select2.css') }}" rel="stylesheet">{{-- Select2 --}}
    <link href="{{ asset('plugins/iCheck/all.css') }}" rel="stylesheet">{{-- iCheck --}}
    <link href="{{ asset('plugins/datetimePicker/css/tempusdominus-bootstrap-4.css') }}" rel="stylesheet">{{-- dateTimePicker --}}
@endsection

@section('staff_content')
<form role="form" id="pembelianForm">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-12 col-lg-4">{{-- Form Pembelian --}}
                    <div class="card">
                        <div class="card-header no-border">
                            <h3 class="card-title"><i class="fa fa-th"></i> <span id="span_title">Form Pembelian</span></h3>
                        </div>
                        <div class="card-body">
                            <div class="form-group" id="field-supplier_id">{{-- Supplier --}}
                                <label for="input-supplier_id">Supplier <i class="fa fa-question-circle-o" data-toggle="tooltip" data-placement="right" title="" data-original-title="Didn't find your Supplier? Add it first with blue + Button"></i></label>
                                <div class="row">
                                    <div class="col-9 col-md-10">
                                        <select name="supplier_id" class="form-control select2" id="input-supplier_id"></select>
                                    </div>
                                    <div class="col-3 col-md-2">
                                        <a data-toggle="modal" data-target="#modalSupplier" class="btn btn-primary text-white w-100"><i class="fa fa-plus"></i></a>
                                    </div>
                                </div>
                            </div>{{-- /.Supplier --}}

                            <div class="form-group" id="field-pembelian_tgl">{{-- Pembelian Tanggal --}}
                                <label for="input-pembelian_tgl">Tanggal Pembelian</label>
                                <input type="text" name="pembelian_tgl" class="form-control datetimepicker-input" id="input-pembelian_tgl" data-toggle="datetimepicker" data-target="#input-pembelian_tgl">
                            </div>{{-- /.Pembelian Tanggal --}}

                            <div class="form-group" id="field-pembelian_detail">{{-- Pembelian Detail --}}
                                <label for="input-pembelian_detail">Detail</label>
                                <textarea placeholder="Detail pembelian" class="form-control" id="input-pembelian_detail" name="pembelian_detail"></textarea>
                            </div>{{-- Pembelian Detail --}}
                        </div>
                    </div>
                </div>{{-- Form Pembelian --}}

                <div class="col-12 col-lg-8">{{-- Form Item --}}
                    <div class="card">
                        <div class="card-header no-border">
                            <h3 class="card-title"><i class="fa fa-th"></i> <span id="span_title">Item Pembelian</span></h3>
                        </div>

                        <div class="card-body">
                            <div id="transaksi_wrapper">{{-- Item Pembelian --}}
                                <div class="mb-2 transaksi_content" id="content-1">
                                    <div class="row">
                                        <div class="col-12 col-md-6">{{-- Nama Barang --}}
                                            <div class="form-group" id="field_1-barang_id">
                                                <label for="input_1-barang_id">Kode Barang</label>
                                                <select name="barang_id[]" class="form-control select2" id="input_1-barang_id" onchange="setBarangDetail('1')">
                                                    @foreach ($kategori as $item_k)
                                                    <optgroup label="{{ $item_k['kategori_nama'] }}">
                                                        @foreach ($barang as $item_b)
                                                            @if($item_b['kategori_id'] == $item_k['id'])
                                                            <option value="{{ $item_b['id'] }}">{{ $item_k['kategori_kode'].'-'.$item_b['barang_kode'].' / '.$item_b['barang_nama'] }}</option>
                                                            @endif
                                                        @endforeach
                                                    </optgroup>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>{{-- /.Nama Barang --}}
                                        <div class="col-12 col-md-2">{{-- Harga Beli --}}
                                            <div class="form-group" id="field_1-harga_beli">
                                                <label for="input_1-harga_beli">Harga Beli</label>
                                                <input type="number" name="harga_beli[]" class="form-control" id="input_1-harga_beli" min="0" value="0" placeholder="0" onchange="itemSubTotal('1')" required>
                                            </div>
                                        </div>{{-- /.Harga Beli --}}
                                        <div class="col-12 col-md-2">{{-- QTY --}}
                                            <div class="form-group" id="field_1-qty">
                                                <label for="input_1-qty">QTY</label>
                                                <input type="number" name="qty[]" class="form-control" id="input_1-qty" min="1" value="1" placeholder="0" onchange="itemSubTotal('1')" required>
                                            </div>
                                        </div>{{-- /.QTY --}}
                                        <div class="col-12 col-md-2">{{-- SubTotal --}}
                                            <div class="form-group" id="field_1-subTotal">
                                                <label for="input_1-subTotal">SubTotal</label>
                                                <input type="number" name="subTotal[]" class="form-control subTotal" id="input_1-subTotal" min="0" placeholder="0" readonly>
                                            </div>
                                        </div>{{-- /.SubTotal --}}
                                    </div>
                                    <hr class="my-2">
                                </div>
                            </div>{{-- Item Pembelian --}}
                            <a class="btn btn-info btn-sm icon-btn mb-2 text-white" id="addMore">
                                <i class="mdi mdi-plus"></i> Add new Row
                            </a>

                            {{-- Rincian Biaya --}}
                            <div class="offset-md-6">
                                <div class="form-group" id="field-pembayaran_tgl">{{-- Pembayaran Tanggal --}}
                                    <label for="input-pembayaran_tgl">Tanggal Pembayaran</label>
                                    <input type="text" name="pembayaran_tgl" class="form-control datetimepicker-input" id="input-pembayaran_tgl" data-toggle="datetimepicker" data-target="#input-pembayaran_tgl">
                                </div>{{-- /.Pembayaran Tanggal --}}

                                <div class="form-group" id="field-jumlah">{{-- Jumlah --}}
                                    <label for="input-jumlah">Jumlah</label>
                                    <input type="number" name="subTotal" class="form-control" id="input-jumlah" min="0" placeholder="0" readonly>
                                </div>{{-- /.Jumlah --}}

                                <div class="form-group" id="field-biaya_lain">{{-- Biaya Lain --}}
                                    <label for="input-biaya_lain">Biaya Lain</label>
                                    <input type="number" name="biaya_lain" class="form-control" id="input-biaya_lain" min="0" value="0" placeholder="0" onchange="hitungTotal()">
                                </div>{{-- /.Jumlah --}}

                                <div class="form-group" id="field-diskon">{{-- Diskon --}}
                                    <label for="input-diskon">Diskon</label>
                                    <input type="number" name="diskon" class="form-control" id="input-diskon" min="0" value="0" placeholder="0" onchange="hitungTotal()">
                                </div>{{-- /.Diskon --}}

                                <div class="form-group" id="field-total">{{-- Total --}}
                                    <label for="input-total">Total</label>
                                    <input type="number" name="total" class="form-control" id="input-total" min="0" placeholder="0" readonly>
                                </div>{{-- /.Total --}}

                                <div class="form-group" id="field-bayar">{{-- Bayar --}}
                                    <label for="input-bayar">Bayar</label>
                                    <div class="input-group">
                                        <input type="number" name="bayar" class="form-control" id="input-bayar" min="0" value="0" placeholder="0" onchange="hitungKekurangan()">
                                        <div class="btn-group">
                                            <a onclick="bayar('dp')" class="btn btn-info text-white">DP 50%</a>
                                            <a onclick="bayar('lunas')" class="btn btn-primary text-white">Lunas</a>
                                        </div>
                                    </div>
                                </div>{{-- /.Total --}}

                                <div class="form-group" id="field-kekurangan">{{-- Kekurangan --}}
                                    <label for="input-kekurangan">Kekurangan</label>
                                    <input type="number" name="kekurangan" class="form-control" id="input-kekurangan" min="0" placeholder="0" readonly>
                                </div>{{-- /.Kekurangan --}}
                            </div>
                            {{-- /.Rincian Biaya --}}
                        </div>
                    </div>
                </div>{{-- /.Form Item --}}
            </div>
        </div>

        <div class="card-footer">
            <div class="form-group text-right">
                <button type="reset" id="pembelianReset" class="btn btn-danger text-white">Reset</button>
                <button type="submit" class="btn btn-primary text-white">Submit</button>
            </div>
        </div>
    </div>
</form>

{{--  Modal for Supplier  --}}
<div class="modal fade" id="modalSupplier" tabindex="-1" role="dialog" aria-labelledby="labelSupplier" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="labelSupplier">Form Tambah Supplier</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form role="form" id="supplierForm">{{-- Form Start --}}
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

                    <div class="form-group text-right">
                        <button type="reset" id="supplierReset" class="btn btn-danger text-white">Reset</button>
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
{{--  /.Modal for Supplier  --}}
@endsection

{{--  Require Js for this page  --}}
@section('plugins_js')
    <script src="{{ asset('plugins/select2/select2.js') }}"></script>{{-- select2 --}}
    <script src="{{ asset('plugins/iCheck/icheck.js') }}"></script>{{-- iCheck --}}
    <script src="{{ asset('plugins/datetimePicker/js/tempusdominus-bootstrap-4.js') }}"></script>{{-- dateTimePicker --}}
    <script src="{{ asset('plugins/ckeditor-classic/ckeditor.js') }}"></script>{{-- ckeditor 5 --}}
@endsection

@section('inline_js')
<script>
    //Set ckeditor
    ClassicEditor.create(
        document.querySelector( '#input-pembelian_detail' ), {
            removePlugins: [ "Image", "ImageCaption", "ImageStyle", "ImageToolbar", "ImageUpload" ]
        }
    ).then(
        newEditor => {ckeditor = newEditor;}
    ).catch(
        error => {console.error( error );}
    );

    $(document).ready(function(){
        document.title = "BakulVisor | Tambah Pembelian";
        $("#mn-pembelian").closest('li').addClass('menu-open');
        $("#mn-pembelian").addClass('active');
        $("#sub-pembelian_tambah").addClass('active');

        //Set for select2
        $('.select2').select2();
        //Set for Supplier select2
        loadSupplierData();
        //Set for Barang Data
        setBarangDetail('1');

        //Init for datetimepicker
        $('#input-pembelian_tgl').datetimepicker({
            useCurrent: false,
            format: 'YYYY-MM-DD HH:mm',
            defaultDate: '{{ date("Y-m-d H:i:00") }}',
            maxDate : '{{ date("Y-m-d H:i:00") }}'
        });
        $('#input-pembayaran_tgl').datetimepicker({
            useCurrent: false,
            format: 'YYYY-MM-DD HH:mm',
            defaultDate: '{{ date("Y-m-d H:i:00") }}',
            maxDate : '{{ date("Y-m-d H:i:00") }}'
        });
    });

    {{-- This function is for auto Calculation --}}
    function itemSubTotal(item){
        var harga_beli = parseInt($("#input_"+item+"-harga_beli").val());
        var qty = parseInt($("#input_"+item+"-qty").val());

        var hitung = harga_beli * qty;
        //console.log("Hasil Hitung Item "+item+" : "+hitung);
        $("#input_"+item+"-subTotal").val(hitung);

        hitungJumlah();
    }
    function hitungJumlah(){
        var jumlah = 0;
        var jumlahAmount = $('.subTotal').length;

        //console.log("Hitung Jumlah Running. Jumlah field : "+jumlahAmount);

        //console.log("Jumlah Class Amount : "+$("input.amountHarga").length);
        $(".subTotal").each(function(){
            if (!Number.isNaN(parseInt(this.value, 10))){
                //console.log("Perhitungan dijalankan");
                jumlah += parseInt(this.value, 10);
                $("#input-jumlah").val(parseInt(jumlah));
            }
        });
        hitungTotal();
    }
    function hitungTotal(){
        var jumlah = parseInt($("#input-jumlah").val());
        var biayaLain = parseInt($("#input-biaya_lain").val());
        var diskon = parseInt($("#input-diskon").val());

        var total = jumlah + biayaLain - diskon;
        $("#input-total").val(total);
        hitungKekurangan();
    }
    function bayar(permintaan){
        var total = parseInt($("#input-total").val());
        if(permintaan == 'dp'){
            //DP 50%
            var bayar = 0.5 * total;
            $("#input-bayar").val(bayar);
        } else {
            //Lunas
            var bayar = total;
            $("#input-bayar").val(bayar);
        }
        hitungKekurangan();
    }
    function hitungKekurangan(){
        var total = parseInt($("#input-total").val());
        var bayar = parseInt($("#input-bayar").val());

        var kekurangan = total - bayar;
        $("#input-kekurangan").val(kekurangan);
    }
    {{-- /.This function is for auto Calculation --}}

    {{-- This function is for Barang --}}
    function setBarangDetail(item){
        var barang_id = $("#input_"+item+"-barang_id").val();

        $.ajax({
            method: "GET",
            url: "{{ url('/data/barang/') }}/"+barang_id,
            success: function(result){
                $("#input_"+item+"-harga_beli").val(result.data[0]['barang_hBeli']);

                itemSubTotal(item);
            }
        });
    }
    {{-- /.This function is for Barang --}}

    {{-- This function is for Supplier --}}
    $("#supplierForm").submit(function(e){ //Prevent default Action for Form
        e.preventDefault();
        supplierAction();
    });
    function supplierAction(){
        $(".error-block").remove();
        $(".form-control").removeClass('has-error');
        $(".input-group-text").removeClass('has-error');

        var formMethod = 'POST';
        var url_link = "{{ url('/staff/supplier') }}";

        $.ajax({
            method: formMethod,
            url: url_link,
            data: $("#supplierForm").serialize(),
            cache: false,
            success: function(result){
                //console.log(result);
                $('#modalSupplier').modal('hide');

                //Show alert
                topright_notify(result.message);
                loadSupplierData();
                //ResetForm
                supplierReset();
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
    $("#supplierReset").click(function(e){ //Prevent default Action for Form
        e.preventDefault();
        supplierReset();
    });
    function supplierReset(){
        $(".error-block").remove();
        $(".form-control").removeClass('has-error');
        $(".input-group-text").removeClass('has-error');

        $("#input-supplier_nama").val('');
        $("#input-supplier_kontak").val('');
        $("#input-supplier_detail").val('');
    }
    function loadSupplierData(){
        $.ajax({
            method: "GET",
            url: "{{ url('/list/supplier') }}",
            cache: false,
            success: function(result){
                //console.log(result);

                if(result != null && $("#input-supplier_id").children('option').length){
                    //console.log("Select2 terisi");
                    $.each(result.data, function(key, result){
                        //console.log("Result : "+JSON.stringify(result));
                        if(result['supplier_kontak'] == "null" || result['supplier_kontak'] == null || result['supplier_kontak'] == ""){
                            var kontak = "";
                        } else {
                            var kontak = "/"+result['supplier_kontak'];
                        }
                        var selectData = {
                            id: result['id'],
                            text: result['supplier_nama']+kontak
                        };

                        //Cek apakah opsi sudah ada di select2
                        if(!$('#input-supplier_id').find("option[value='" + result['id'] + "']").length){
                            //console.log(result['kategori_nama']+" belum ada");
                            var newOption = new Option(selectData.text, selectData.id, true, true);
                            $('#input-supplier_id').append(newOption).trigger('change');
                        }
                    });
                } else {
                    //console.log("Select2 kosong");
                    $.each(result.data, function(key, result){
                        //console.log("Result : "+JSON.stringify(result));
                        if(result['supplier_kontak'] == "null" || result['supplier_kontak'] == null || result['supplier_kontak'] == ""){
                            var kontak = "";
                        } else {
                            var kontak = "/"+result['supplier_kontak'];
                        }
                        var selectData = {
                            id: result['id'],
                            text: result['supplier_nama']+kontak
                        };
                        var newOption = new Option(selectData.text, selectData.id, false, false);
                        $('#input-supplier_id').append(newOption).trigger('change');
                    });
                }
            }
        });
    }
    {{-- /.This function is for Supplier --}}

    {{-- This function is for Pembelian --}}
    var awal = 2;
    var akhir = 5; //Max Field
    var add = document.getElementById("addMore");
    var wrap = document.getElementById("transaksi_wrapper");
    $(add).click(function(e){
        e.preventDefault();
        var konten = parseInt($('.transaksi_content').length) + 1;

        $('<div class="mb-2 transaksi_content konten_tambahan" id="content-'+awal+'" style="display: none;"><div class="row"><div class="col-12 col-md-6">{{-- Nama Barang --}}<div class="form-group" id="field_'+awal+'-barang_id"><label for="input_'+awal+'-barang_id">Kode Barang</label><select name="barang_id[]" class="form-control select2" id="input_'+awal+'-barang_id" onchange="setBarangDetail('+awal+')"> @foreach ($kategori as $item_k) <optgroup label="{{ $item_k['kategori_nama'] }}"> @foreach ($barang as $item_b) @if($item_b['kategori_id'] == $item_k['id']) <option value="{{ $item_b['id'] }}">{{ $item_k['kategori_kode'].'-'.$item_b['barang_kode'].' / '.$item_b['barang_nama'] }}</option> @endif @endforeach </optgroup> @endforeach </select></div></div>{{-- /.Nama Barang --}}<div class="col-12 col-md-2">{{-- Harga Beli --}}<div class="form-group" id="field_'+awal+'-harga_jual"><label for="input_'+awal+'-harga_beli">Harga Beli</label><input type="number" name="harga_beli[]" class="form-control" id="input_'+awal+'-harga_beli" min="0" value="0" placeholder="0" onchange="itemSubTotal('+awal+')" required></div></div>{{-- /.Harga Beli --}}<div class="col-12 col-md-2">{{-- QTY --}}<div class="form-group" id="field_'+awal+'-qty"><label for="input_'+awal+'-qty">QTY</label><input type="number" name="qty[]" class="form-control" id="input_'+awal+'-qty" min="1" value="1" placeholder="0" onchange="itemSubTotal('+awal+')" required></div></div>{{-- /.QTY --}}<div class="col-12 col-md-2">{{-- SubTotal --}}<div class="form-group" id="field_'+awal+'-subTotal"><label for="input_'+awal+'-subTotal">SubTotal</label><div class="input-group"><input type="number" name="subTotal[]" class="form-control subTotal" id="input_'+awal+'-subTotal" min="0" placeholder="0" readonly><a onclick="removeMore('+awal+')" class="btn text-white btn-danger btnhapus" ><i class="fa fa-trash"></i></a></div></div></div>{{-- /.SubTotal --}}</div><hr class="my-2"></div>').appendTo($("#transaksi_wrapper")).slideDown("slow", "swing");

        $('.select2-container').remove();
        $('.select2').select2();
        $(this).find(".select2").prop('selectedIndex', 0).change();
        setBarangDetail(awal);
        awal++;
    });
    function removeMore(id){
        var konten = parseInt($('.transaksi_content').length) - 1;

        if(confirm('Are you sure you want to delete this element?')) {
            $("#content-"+id).slideUp(function(){
                $(this).remove();
                hitungJumlah();
            });
        }
    }

    $("#pembelianForm").submit(function(e){ //Prevent default Action for Form
        e.preventDefault();
        pembelianAction();
    });
    function pembelianAction(){
        $("#input-pembelian_detail").val(editorData = ckeditor.getData());

        $(".error-block").remove();
        $(".form-control").removeClass('has-error');
        $(".input-group-text").removeClass('has-error');

        var formMethod = "POST";
        var url_link = "{{ url('/staff/pembelian') }}";
        $.ajax({
            method: formMethod,
            url: url_link,
            data: $("#pembelianForm").serialize(),
            cache: false,
            success: function(result){
                console.log(result.invoice);

                if(result.error != false){
                    showError(result.message);
                } else {
                    //Transaksi Berhasil
                    showSuccess_redirect(result.message, result.invoice);
                }
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
    {{-- /.This function is for Pembelian --}}
</script>
@endsection
