@extends('layouts.staff')

{{-- Content Header --}}
@section('staff_content_title')
    <h1 class="m-0 text-dark">(Tambah) Penjualan</h1>
@endsection
@section('staff_content_breadcrumb')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="{{ url('/staff') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ url('/staff/penjualan') }}">Penjualan</a></li>
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
<form role="form" id="penjualanForm">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-12 col-lg-4">{{-- Form Penjualan --}}
                    <div class="card">
                        <div class="card-header no-border">
                            <h3 class="card-title"><i class="fa fa-th"></i> <span id="span_title">Form Penjualan</span></h3>
                        </div>

                        <div class="card-body">
                            <div class="form-group" id="field-toko_id">{{-- Toko --}}
                                <label for="input-toko_id">Toko <i class="fa fa-question-circle-o" data-toggle="tooltip" data-placement="right" title="" data-original-title="Didn't find your Store? Add it first with blue + Button"></i></label>
                                <div class="row mb-2">{{-- Tipe Transaksi --}}
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
                                </div>{{-- Tipe Transaksi --}}

                                <div class="row">
                                    <div class="col-9 col-md-10">
                                        <select name="toko_id" class="form-control select2" id="input-toko_id"></select>
                                    </div>
                                    <div class="col-3 col-md-2">
                                        <a data-toggle="modal" data-target="#modalToko" class="btn btn-primary text-white w-100"><i class="fa fa-plus"></i></a>
                                    </div>
                                </div>
                            </div>{{-- /.Toko --}}

                            <div class="form-group" id="field-kostumer_id">{{-- Kostumer --}}
                                <label for="input-kostumer_id">Kostumer <i class="fa fa-question-circle-o" data-toggle="tooltip" data-placement="right" title="" data-original-title="Didn't find your Customer? Add it first with blue + Button"></i></label>
                                <div class="row">
                                    <div class="col-9 col-md-10">
                                        <select name="kostumer_id" class="form-control select2" id="input-kostumer_id">
                                            <option value="">- None -</option>
                                        </select>
                                    </div>
                                    <div class="col-3 col-md-2">
                                        <a data-toggle="modal" data-target="#modalKostumer" class="btn btn-primary text-white w-100"><i class="fa fa-plus"></i></a>
                                    </div>
                                </div>
                            </div>{{-- /.Kostumer --}}

                            <div class="form-group" id="field-penjualan_tgl">{{-- Penjualan Tanggal --}}
                                <label for="input-penjualan_tgl">Tanggal Penjualan</label>
                                <input type="text" name="penjualan_tgl" class="form-control datetimepicker-input" id="input-penjualan_tgl" data-toggle="datetimepicker" data-target="#input-penjualan_tgl">
                            </div>{{-- /.Penjualan Tanggal --}}

                            <div class="form-group" id="field-penjualan_detail">{{-- Penjualan Detail --}}
                                <label for="input-penjualan_detail">Detail</label>
                                <textarea placeholder="Detail Penjualan" class="form-control" id="input-penjualan_detail" name="penjualan_detail"></textarea>
                            </div>{{-- Penjualan Detail --}}
                        </div>
                    </div>
                </div>{{-- /.Form Penjualan --}}

                <div class="col-12 col-lg-8">
                    <div class="card">
                        <div class="card-header no-border">
                            <h3 class="card-title"><i class="fa fa-th"></i> <span id="span_title">Item Penjualan</span></h3>
                        </div>

                        <div class="card-body">
                            <div id="transaksi_wrapper">{{-- Item Penjualan --}}
                                <div class="mb-2 transaksi_content" id="content-1">
                                    <div class="row">
                                        <div class="col-12 col-md-4">{{-- Nama Barang --}}
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
                                        <div class="form-group" id="field_1-harga_beli">{{-- Harga Beli --}}
                                            <input type="hidden" name="harga_beli[]" class="form-control" id="input_1-harga_beli" min="0" placeholder="0">
                                        </div>{{-- /.Harga Beli --}}
                                        <div class="col-12 col-md-2">{{-- Harga Jual --}}
                                            <div class="form-group" id="field_1-harga_jual">
                                                <label for="input_1-harga_jual">Harga Jual</label>
                                                <input type="number" name="harga_jual[]" class="form-control" id="input_1-harga_jual" min="0" placeholder="0" onchange="itemSubTotal('1')">
                                            </div>
                                        </div>{{-- /.Harga Jual --}}
                                        <div class="col-12 col-md-2">{{-- Diskon --}}
                                            <div class="form-group" id="field_1-diskon">
                                                <label for="input_1-diskon">Diskon</label>
                                                <input type="number" name="diskon[]" class="form-control" id="input_1-diskon" min="0" value="0" placeholder="0" onchange="itemSubTotal('1')">
                                            </div>
                                        </div>{{-- /.Diskon --}}
                                        <div class="col-12 col-md-2">{{-- QTY --}}
                                            <div class="form-group" id="field_1-qty">
                                                <label for="input_1-qty">QTY</label>
                                                <input type="number" name="qty[]" class="form-control" id="input_1-qty" min="1" value="1" placeholder="0" onchange="itemSubTotal('1')">
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
                            </div>{{-- Item Penjualan --}}
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
                </div>
            </div>
        </div>

        <div class="card-footer">
            <div class="form-group text-right">
                <button type="reset" id="formReset" class="btn btn-danger text-white">Reset</button>
                <button type="submit" class="btn btn-primary text-white">Submit</button>
            </div>
        </div>
    </div>
</form>

{{--  Modal for Toko  --}}
<div class="modal fade" id="modalToko" tabindex="-1" role="dialog" aria-labelledby="labelToko" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="labelToko">Form Tambah Toko</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form role="form" id="tokoForm">{{-- Form Start --}}
                    <div class="form-group" id="field-toko_tipe">{{-- Tipe Toko --}}
                        <input type="text" name="toko_tipe" class="form-control" placeholder="Tipe Toko" id="input-toko_tipe" readonly>
                    </div>{{-- /.Tipe Toko --}}

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

                    <div class="form-group text-right">
                        <button type="reset" id="tokoReset" class="btn btn-danger text-white">Reset</button>
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
{{--  /.Modal for Toko  --}}

{{--  Modal for Kostumer  --}}
<div class="modal fade" id="modalKostumer" tabindex="-1" role="dialog" aria-labelledby="labelKostumer" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="labelKostumer">Form Tambah Kostumer</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form role="form" id="kostumerForm">{{-- Form Start --}}
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

                        <div class="form-group text-right">
                            <button type="reset" id="kostumerReset" class="btn btn-danger text-white">Reset</button>
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
    {{--  /.Modal for Kostumer  --}}
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
        document.querySelector( '#input-penjualan_detail' ), {
            removePlugins: [ "Image", "ImageCaption", "ImageStyle", "ImageToolbar", "ImageUpload" ]
        }
    ).then(
        newEditor => {ckeditor = newEditor;}
    ).catch(
        error => {console.error( error );}
    );

    $(document).ready(function(){
        document.title = "BakulVisor | Tambah Penjualan";
        $("#mn-penjualan").closest('li').addClass('menu-open');
        $("#mn-penjualan").addClass('active');
        $("#sub-penjualan_tambah").addClass('active');

        //Set for Default Tipe Transaksi
        $("#tipe_offline").prop('checked', true);
        $("#tipe_offline").iCheck('update');

        //Set for select2
        $('.select2').select2();
        //Set for Toko select2
        loadTokoData();
        loadKostumerData();
        //Set for iCheck
        $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
            checkboxClass: 'icheckbox_minimal-blue',
            radioClass   : 'iradio_minimal-blue'
        });
        $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
            checkboxClass: 'icheckbox_flat-blue',
            radioClass   : 'iradio_flat-blue'
        });

        //Init for datetimepicker
        $('#input-penjualan_tgl').datetimepicker({
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

        setBarangDetail('1');
    });

    //This is for item Penjualan
    var awal = 2;
    var akhir = 5; //Max Field
    var add = document.getElementById("addMore");
    var wrap = document.getElementById("transaksi_wrapper");
    $(add).click(function(e){
        e.preventDefault();
        var konten = parseInt($('.transaksi_content').length) + 1;

        $('<div class="mb-2 transaksi_content" id="content-'+awal+'" style="display: none;"><div class="row"><div class="col-12 col-md-4">{{-- Nama Barang --}}<div class="form-group" id="field_'+awal+'-barang_id"><label for="input_'+awal+'-barang_id">Kode Barang</label><select name="barang_id[]" class="form-control select2" id="input_'+awal+'-barang_id" onchange="setBarangDetail('+awal+')"> @foreach ($kategori as $awal_k) <optgroup label="{{ $awal_k['kategori_nama'] }}"> @foreach ($barang as $awal_b) @if($awal_b['kategori_id'] == $awal_k['id']) <option value="{{ $awal_b['id'] }}">{{ $awal_k['kategori_kode'].'-'.$awal_b['barang_kode'].' / '.$awal_b['barang_nama'] }}</option> @endif @endforeach </optgroup> @endforeach </select></div></div>{{-- /.Nama Barang --}}<div class="form-group" id="field_'+awal+'-harga_beli">{{-- Harga Beli --}}<input type="hidden" name="harga_beli[]" class="form-control" id="input_'+awal+'-harga_beli" min="0" placeholder="0"></div>{{-- /.Harga Beli --}}<div class="col-12 col-md-2">{{-- Harga Jual --}}<div class="form-group" id="field_'+awal+'-harga_jual"><label for="input_'+awal+'-harga_jual">Harga Jual</label><input type="number" name="harga_jual[]" class="form-control" id="input_'+awal+'-harga_jual" min="0" placeholder="0" onchange="itemSubTotal('+awal+')"></div></div>{{-- /.Harga Jual --}}<div class="col-12 col-md-2">{{-- Diskon --}}<div class="form-group" id="field_'+awal+'-diskon"><label for="input_'+awal+'-diskon">Diskon</label><input type="number" name="diskon[]" class="form-control" id="input_'+awal+'-diskon" min="0" value="0" placeholder="0" onchange="itemSubTotal('+awal+')"></div></div>{{-- /.Diskon --}}<div class="col-12 col-md-2">{{-- QTY --}}<div class="form-group" id="field_'+awal+'-qty"><label for="input_'+awal+'-qty">QTY</label><input type="number" name="qty[]" class="form-control" id="input_'+awal+'-qty" min="1" value="1" placeholder="0" onchange="itemSubTotal('+awal+')"></div></div>{{-- /.QTY --}}<div class="col-12 col-md-2">{{-- SubTotal --}}<div class="form-group" id="field_'+awal+'-subTotal"><label for="input_'+awal+'-subTotal">SubTotal</label><div class="input-group"><input type="number" name="subTotal[]" class="form-control subTotal" id="input_'+awal+'-subTotal" min="0" placeholder="0" readonly><a onclick="removeMore('+awal+')" class="btn text-white btn-danger btnhapus" ><i class="fa fa-trash"></i></a></div></div></div>{{-- /.SubTotal --}}</div><hr class="my-2">').appendTo($("#transaksi_wrapper")).slideDown("slow", "swing");

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
                //hitungTotal();
            });
        }
    }


    function itemSubTotal(item){
        var harga_jual = parseInt($("#input_"+item+"-harga_jual").val());
        var diskon = parseInt($("#input_"+item+"-diskon").val());
        var qty = parseInt($("#input_"+item+"-qty").val());

        var hitung = (harga_jual * qty) - diskon;
        //console.log("Hasil Hitung Item "+item+" : "+hitung);
        $("#input_"+item+"-subTotal").val(hitung);

        hitungJumlah();
    }
    function hitungJumlah(){
        var jumlah = 0;
        var jumlahAmount = $(".subTotal").lenght;
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

        var total = jumlah + biayaLain;
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


    function setBarangDetail(item){
        var barang_id = $("#input_"+item+"-barang_id").val();

        $.ajax({
            method: "GET",
            url: "{{ url('/data/barang/') }}/"+barang_id,
            success: function(result){
                $("#input_"+item+"-harga_beli").val(result.data[0]['barang_hBeli']);
                $("#input_"+item+"-harga_jual").val(result.data[0]['barang_hJual']);

                itemSubTotal(item);
            }
        });
    }
    //This is for item Penjualan

    //This is for Penjualan
    $("#penjualanForm").submit(function(e){ //Prevent default Action for Form
        e.preventDefault();
        penjualanAction();
    });
    function penjualanAction(){
        $("#input-penjualan_detail").val(editorData = ckeditor.getData());

        $(".error-block").remove();
        $(".form-control").removeClass('has-error');
        $(".input-group-text").removeClass('has-error');

        var formMethod = "POST";
        var url_link = "{{ url('/staff/penjualan') }}";

        $.ajax({
            method: formMethod,
            url: url_link,
            data: $("#penjualanForm").serialize(),
            cache: false,
            success: function(result){
                console.log(result);

                if(result.error != false){
                    showError(result.error);
                } else {
                    //Transaksi Berhasil
                    //console.log("error false");
                    showSuccess_redirect(result.message, result.invoice);
                }
                //Show alert
                //topright_notify(result.message);
                //ResetForm
                //formReset();
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
    //.This is for Penjualan

    //This is for Toko
    $("#tipe_offline").on('ifChecked', function(){
        loadTokoData();
    });
    $("#tipe_online").on('ifChecked', function(){
        loadTokoData();
    });
    //This function is for Set Tipe Toko on Add Toko Modal
    $('#modalToko').on('show.bs.modal', function () {
        tokoReset();
        $("#input-toko_tipe").val($('input[name=toko_tipe]:checked').val());
    });

    function loadTokoData(){
        //Untuk mendapatkan data toko
        var toko_tipe = $("input[name=toko_tipe]:checked").val();
        $.ajax({
            method: "POST",
            url: "{{ url('/list/toko') }}",
            data: {'toko_tipe': toko_tipe},
            cache: false,
            success: function(result){
                //console.log(result);
                $('#input-toko_id').html("");

                if(result != null && $("#input-toko_id").children('option').length){
                    //console.log("Select2 terisi");
                    $.each(result.data, function(key, result){
                        //console.log("Result : "+JSON.stringify(result));
                        var selectData = {
                            id: result['id'],
                            text: result['toko_nama']
                        };

                        //Cek apakah opsi sudah ada di select2
                        if(!$('#input-toko_id').find("option[value='" + result['id'] + "']").length){
                            //console.log(result['kategori_nama']+" belum ada");
                            var newOption = new Option(selectData.text, selectData.id, true, true);
                            $('#input-toko_id').append(newOption).trigger('change');
                        }
                    });
                } else {
                    //console.log("Select2 kosong");
                    $.each(result.data, function(key, result){
                        //console.log("Result : "+JSON.stringify(result));
                        var selectData = {
                            id: result['id'],
                            text: result['toko_nama']
                        };
                        var newOption = new Option(selectData.text, selectData.id, false, false);
                        $('#input-toko_id').append(newOption).trigger('change');
                    });
                }
            }
        });
    }

    $("#tokoForm").submit(function(e){ //Prevent default Action for Form
        e.preventDefault();
        tokoAction();
    });
    function tokoAction(){
        //console.log("Running Kategori");
        //Remove All Errors block that exists
        $(".error-block").remove();
        $(".form-control").removeClass('has-error');
        $(".input-group-text").removeClass('has-error');

        $.ajax({
            method: "POST",
            url: "{{ url('/staff/toko') }}",
            data: $("#tokoForm").serialize(),
            cache: false,
            success: function(result){
                //console.log(result);
                $('#modalToko').modal('hide');
                loadTokoData();

                //Show alert
                topright_notify(result.message);
                //ResetForm
                tokoReset();
            },
            error: function( jqXHR, textStatus, errorThrown ) {
                //console.log(jqXHR);

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
    $("#tokoReset").click(function(e){ //Prevent default Action for Form
        e.preventDefault();
        tokoReset();
    });
    function tokoReset(){
        $(".error-block").remove();
        $(".form-control").removeClass('has-error');
        $(".input-group-text").removeClass('has-error');

        $("#input-toko_tipe").val($('input[name=toko_tipe]:checked').val());
        $("#input-toko_nama").val('');
        $("#input-toko_alamat").val('');
        $("#input-toko_link").val('');
        $("#input-toko_kontak").val('');
    }
    //.This is for Toko

    //This is for Kostumer
    //Load Kostumer Data
    function loadKostumerData(){
        $.ajax({
            method: "GET",
            url: "{{ url('/list/kostumer') }}",
            cache: false,
            success: function(result){
                //console.log(result);

                if(result != null && $("#input-kostumer_id").children('option').length){
                    //console.log("Select2 terisi");
                    $.each(result.data, function(key, result){
                        //console.log("Result : "+JSON.stringify(result));
                        if(result['kostumer_kontak'] == "null" || result['kostumer_kontak'] == null || result['kostumer_kontak'] == ""){
                            var kontak = "";
                        } else {
                            var kontak = "/"+result['kostumer_kontak'];
                        }
                        var selectData = {
                            id: result['id'],
                            text: result['kostumer_nama']+kontak
                        };

                        //Cek apakah opsi sudah ada di select2
                        if(!$('#input-kostumer_id').find("option[value='" + result['id'] + "']").length){
                            //console.log(result['kategori_nama']+" belum ada");
                            var newOption = new Option(selectData.text, selectData.id, false, false);
                            $('#input-kostumer_id').append(newOption).trigger('change');
                        }
                    });
                } else {
                    //console.log("Select2 kosong");
                    $.each(result.data, function(key, result){
                        //console.log("Result : "+JSON.stringify(result));
                        if(result['kostumer_kontak'] == "null" || result['kostumer_kontak'] == null || result['kostumer_kontak'] == ""){
                            var kontak = "";
                        } else {
                            var kontak = "/"+result['kostumer_kontak'];
                        }
                        var selectData = {
                            id: result['id'],
                            text: result['kostumer_nama']+kontak
                        };
                        var newOption = new Option(selectData.text, selectData.id, false, false);
                        $('#input-kostumer_id').append(newOption).trigger('change');
                    });
                }
            }
        });
    }

    $("#kostumerForm").submit(function(e){ //Prevent default Action for Form
        e.preventDefault();
        kostumerAction();
    });
    function kostumerAction(){
        //console.log("Running Kategori");
        //Remove All Errors block that exists
        $(".error-block").remove();
        $(".form-control").removeClass('has-error');
        $(".input-group-text").removeClass('has-error');

        var formMethod = 'POST';
        var url_link = "{{ url('/staff/kostumer') }}";

        $.ajax({
            method: formMethod,
            url: url_link,
            data: $("#kostumerForm").serialize(),
            cache: false,
            success: function(result){
                //console.log(result);
                $('#modalKostumer').modal('hide');

                //Show alert
                topright_notify(result.message);
                loadKostumerData();
                //ResetForm
                kostumerReset();
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
    $("#kostumerReset").click(function(e){ //Prevent default Action for Form
        e.preventDefault();
        kostumerReset();
    });
    function kostumerReset(){
        $(".error-block").remove();
        $(".form-control").removeClass('has-error');
        $(".input-group-text").removeClass('has-error');

        $("#input-kostumer_nama").val('');
        $("#input-kostumer_kontak").val('');
        $("#input-kostumer_detail").val('');
    }
    //.This is for Kostumer
</script>
@endsection
