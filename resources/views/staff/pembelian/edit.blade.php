@extends('layouts.staff')

{{-- Content Header --}}
@section('staff_content_title')
    <h1 class="m-0 text-dark">(Edit) Pembelian</h1>
@endsection
@section('staff_content_breadcrumb')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="{{ url('/staff') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ url('/pemmbelian') }}">Pembelian</a></li>
        <li class="breadcrumb-item active">Edit Pembelian</li>
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
                                <select name="supplier_id" class="form-control select2" id="input-supplier_id"></select>
                            </div>{{-- /.Supplier --}}

                            <div class="form-group" id="field-pembelian_tgl">{{-- Pembelian Tanggal --}}
                                <label for="input-pembelian_tgl">Tanggal Pembelian</label>
                                <input type="text" name="pembelian_tgl" class="form-control datetimepicker-input" id="input-pembelian_tgl" data-toggle="datetimepicker" data-target="#input-pembelian_tgl">
                            </div>{{-- /.Pembelian Tanggal --}}

                            <div class="form-group" id="field-pembelian_detail">{{-- Pembelian Detail --}}
                                <label for="input-pembelian_detail">Detail</label>
                                <textarea placeholder="Detail pembelian" class="form-control" id="input-pembelian_detail" name="pembelian_detail">{{ $pembelian->pembelian_detail }}</textarea>
                            </div>{{-- Pembelian Detail --}}
                        </div>
                    </div>
                </div>{{-- Form Pembelian --}}

                <div class="col-12 col-lg-8">{{-- Pembelian Item --}}
                    <div class="card">
                        <div class="card-header no-border">
                            <h3 class="card-title"><i class="fa fa-th"></i> <span id="span_title">Item Penjualan</span></h3>
                        </div>
                        <div class="card-body">
                            <div id="transaksi_wrapper">{{-- Item Pembelian --}}
                                @php $i = 1; @endphp
                                @foreach ($pembelian->pembelianItem as $item)
                                <div class="row">
                                    <div class="col-12 col-md-6">{{-- Nama Barang --}}
                                        <div class="form-group" id="field_{{ $i }}-barang_id">
                                            <label for="input_{{ $i }}-barang_id">Kode Barang</label>
                                            <input type="hidden" name="barang_id[]" class="form-control" id="input_{{ $i }}-barang_id" value="{{ $item->barang_id }}" readonly>
                                            <input type="text" name="barang_nama[]" class="form-control" id="input_{{ $i }}-barang_nama" value="{{ $item->barang->kategori->kategori_kode.'-'.$item->barang->barang_kode.' / '.$item->barang->barang_nama }}" readonly>
                                        </div>
                                    </div>{{-- Nama Barang --}}
                                    <div class="col-12 col-md-2">{{-- Harga Beli --}}
                                        <div class="form-group" id="field_1-harga_beli">
                                            <label for="input_1-harga_beli">Harga Beli</label>
                                            <input type="number" name="harga_beli[]" class="form-control" id="input_{{ $i }}-harga_beli" min="0" value="{{ $item->harga_beli }}" placeholder="0" onchange="itemSubTotal('{{ $i }}')" required>
                                        </div>
                                    </div>{{-- /.Harga Beli --}}
                                    <div class="col-12 col-md-2">{{-- QTY --}}
                                        <div class="form-group" id="field_1-qty">
                                            <label for="input_1-qty">QTY</label>
                                            <input type="number" name="qty[]" class="form-control" id="input_{{ $i }}-qty" min="1" value="{{ $item->beli_qty }}" placeholder="0" onchange="itemSubTotal('{{ $i }}')" required>
                                        </div>
                                    </div>{{-- /.QTY --}}
                                    <div class="col-12 col-md-2">{{-- SubTotal --}}
                                        <div class="form-group" id="field_1-subTotal">
                                            <label for="input_1-subTotal">SubTotal</label>
                                            <input type="number" name="subTotal[]" class="form-control subTotal" id="input_{{ $i }}-subTotal" min="0" placeholder="0" readonly>
                                        </div>
                                    </div>{{-- /.SubTotal --}}
                                </div>
                                <hr class="my-2">
                                @php $i++; @endphp
                                @endforeach
                            </div>{{-- Item Pembelian --}}

                            {{-- Rincian Biaya --}}
                            @php
                                $biayaLain = 0;
                                $diskon = 0;
                                $bayar = 0;
                            @endphp
                            @foreach ($pembelian->pembelianBayar as $log)
                                @php
                                    $biayaLain = $biayaLain + $log->biaya_lain;
                                    $diskon = $diskon + $log->diskon;
                                    $bayar = $bayar + $log->bayar;
                                @endphp
                            @endforeach

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
                                    <input type="number" name="biaya_lain" class="form-control" id="input-biaya_lain" min="0" value="{{ $biayaLain }}" placeholder="0" onchange="hitungTotal()" required>
                                </div>{{-- /.Jumlah --}}

                                <div class="form-group" id="field-diskon">{{-- Diskon --}}
                                    <label for="input-diskon">Diskon</label>
                                    <input type="number" name="diskon" class="form-control" id="input-diskon" min="0" value="{{ $diskon }}" placeholder="0" onchange="hitungTotal()" required>
                                </div>{{-- /.Diskon --}}

                                <div class="form-group" id="field-total">{{-- Total --}}
                                    <label for="input-total">Total</label>
                                    <input type="number" name="total" class="form-control" id="input-total" min="0" placeholder="0" readonly>
                                </div>{{-- /.Total --}}

                                <div class="form-group" id="field-bayar">{{-- Bayar --}}
                                    <label for="input-bayar">Bayar</label>
                                    <div class="input-group">
                                        <input type="number" name="bayar" class="form-control" id="input-bayar" min="0" value="{{ $bayar }}" placeholder="0" onchange="hitungKekurangan()" required>
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
                </div>{{-- Pembelian Item --}}
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
@endsection

{{--  Require Js for this page  --}}
@section('plugins_js')
    <script src="{{ asset('plugins/select2/select2.js') }}"></script>{{-- select2 --}}
    <script src="{{ asset('plugins/iCheck/icheck.js') }}"></script>{{-- iCheck --}}
    <script src="{{ asset('plugins/datetimePicker/js/tempusdominus-bootstrap-4.js') }}"></script>{{-- dateTimePicker --}}
    <script src="https://cdn.ckeditor.com/ckeditor5/11.0.1/classic/ckeditor.js"></script>{{-- ckeditor 5 --}}
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
        document.title = "BakulVisor | Edit Pembelian";
        $("#mn-pembelian").closest('li').addClass('menu-open');
        $("#mn-pembelian").addClass('active');

        //Set for select2
        $('.select2').select2();
        //Set for Supplier select2
        loadSupplierData("{{ $pembelian->supplier_id }}");

        //Init for datetimepicker
        $('#input-pembelian_tgl').datetimepicker({
            useCurrent: false,
            format: 'YYYY-MM-DD HH:mm:ss',
            defaultDate: '{{ $pembelian->pembelian_tgl }}',
            maxDate : '{{ date("Y-m-d H:i:00") }}'
        });
        $('#input-pembayaran_tgl').datetimepicker({
            useCurrent: false,
            format: 'YYYY-MM-DD HH:mm:ss',
            defaultDate: '{{ date("Y-m-d H:i:00") }}',
            maxDate : '{{ date("Y-m-d H:i:00") }}'
        });

        //Set subJumlah per item
        @php $i = 1; @endphp
        @foreach ($pembelian->pembelianItem as $item)
        itemSubTotal('{{ $i }}');
            @php  $i++; @endphp
        @endforeach
    });

    {{-- This function is for auto Calculation --}}
    function itemSubTotal(item){
        var harga_beli = parseInt($("#input_"+item+"-harga_beli").val());
        var qty = parseInt($("#input_"+item+"-qty").val());

        var hitung = harga_beli * qty;
        //console.log("Hasil Hitung Item "+item+" : "+qty);
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

    {{--  This function is for Pembelian  --}}
    $("#pembelianForm").submit(function(e){ //Prevent default Action for Form
        e.preventDefault();
        pembelianAction();
    });
    function pembelianAction(){
        $("#input-pembelian_detail").val(editorData = ckeditor.getData());

        $(".error-block").remove();
        $(".form-control").removeClass('has-error');
        $(".input-group-text").removeClass('has-error');

        var formMethod = "PUT";
        var url_link = "{{ url('/staff/pembelian').'/'.$pembelian->id }}";
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
                    showSuccess_redirect(result.message, "{{ url('/staff/pembelian') }}/"+result.invoice);
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
    {{--  /.This function is for Pembelian  --}}

    {{--  This function is for Supplier  --}}
    function loadSupplierData(selected_supplier){
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

                //Untuk set sesuai data DB
                if(selected_supplier != undefined){
                    //console.log("Set Sesuai DB, selected : "+selected_supplier);
                    $('#input-supplier_id').val(selected_supplier).trigger('change');
                } else {
                    console.log("Set Index 0");
                    //Set index 0 as selected
                    $('#input-supplier_id').prop('selectedIndex', '0').trigger('change');
                }
            }
        });
    }
    {{--  /.This function is for Supplier  --}}
</script>
@endsection
