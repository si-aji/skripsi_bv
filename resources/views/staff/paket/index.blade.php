@extends('layouts.staff')

{{--  Require CSS for this Page  --}}
@section('plugin_css')
    <link href="{{ asset('plugins/dataTables/datatables.css') }}" rel="stylesheet">
    <link href="{{ asset('plugins/select2/select2.css') }}" rel="stylesheet">{{-- Select2 --}}
@endsection

{{-- Content Header --}}
@section('staff_content_title')
    <h1 class="m-0 text-dark">Paket</h1>
@endsection
@section('staff_content_breadcrumb')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="{{ url('/staff') }}">Home</a></li>
        <li class="breadcrumb-item active">Paket</li>
    </ol>
@endsection{{-- Content Header --}}

@section('staff_content')
    <div class="row">
        <div class="col-12 col-lg-5">{{-- Form Paket --}}
            <div class="card">
                <div class="card-header no-border">
                    <h3 class="card-title"><i class="fa fa-suitcase"></i> <span id="span_title">Form Paket (Insert)</span></h3>
                </div>
                <form role="form" id="paketForm">
                    <div class="card-body">
                        <input type="hidden" name="request" id="request" value="insert">
                        <input type="hidden" name="_method" id="_method" value="POST">

                        <div class="form-group" id="field-paket_nama">{{-- Nama Paket --}}
                            <label for="input-paket_nama">Nama Paket</label>
                            <input type="text" name="paket_nama" class="form-control" placeholder="Nama Paket/Kode Paket" id="input-paket_nama">
                        </div>{{-- /.Nama Paket --}}
                        <div class="row">
                            <div class="col-12 col-lg-6">
                                <div class="form-group" id="field-harga_paket_asli">{{-- Harga Asli --}}
                                    <label for="input-harga_paket">Harga Asli</label>
                                    <input type="number" name="paket-harga_paket_asli" class="form-control" min="0" value="0" id="input-harga_paket_asli" readonly>
                                </div>{{-- /.Harga Asli --}}
                            </div>
                            <div class="col-12 col-lg-6">
                                <div class="form-group" id="field-harga_paket">{{-- Harga Paket --}}
                                    <label for="input-harga_paket">Harga Paket</label>
                                    <input type="number" name="paket_harga" class="form-control" min="0" value="0" id="input-harga_paket" readonly>
                                </div>{{-- /.Harga Paket --}}
                            </div>
                        </div>

                        <div id="paket_wrapper">{{-- Item Paket --}}
                            <div class="mb-2 paket_content" id="content-1">
                                <div class="row">{{-- Paket --}}
                                    <div class="col-12 col-lg-6">
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
                                    </div>
                                    <div class="col-12 col-lg-3">
                                        <div class="form-group" id="field_1-harga_asli">
                                            <label for="input-harga_asli">Harga@ Asli</label>
                                            <input type="number" name="harga_asli[]" class="form-control harga_asli" min="0" value="0" id="input_1-harga_asli" readonly>
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-3">
                                        <div class="form-group" id="field_1-harga_item">
                                            <label for="input-harga_item">Harga Item</label>
                                            <input type="number" name="harga_item[]" class="form-control harga_item" min="0" value="0" id="input_1-harga_item" onchange="hitungHargaPaket()">
                                        </div>
                                    </div>
                                </div>{{-- /.Paket --}}
                                <hr class="my-1">
                            </div>
                        </div>{{-- Item Paket --}}
                        <a class="btn btn-info btn-sm icon-btn mb-2 text-white" id="addMore">
                            <i class="mdi mdi-plus"></i> Add new Row
                        </a>
                    </div>

                    <div class="card-footer">
                        <div class="form-group text-right">
                            <button type="reset" id="paketReset" class="btn btn-danger text-white">Reset</button>
                            <button type="submit" class="btn btn-primary text-white">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>{{-- /.Form Paket --}}

        <div class="col-12 col-lg-7">{{-- DataTable Paket --}}
            <div class="card">
                <div class="card-header no-border">
                    <h3 class="card-title"><span><i class="fa fa-suitcase"></i> List Paket</span></h3>
                </div>
                <div class="card-body">
                    <table class="table table-hover table-striped table-bordered" id="paketTable">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th class="all">Nama Paket</th>
                                <th class="desktop">Barang</th>
                                <th class="desktop">Aksi</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>{{-- /.DataTable Paket --}}
    </div>
@endsection

{{--  Require Js for this page  --}}
@section('plugins_js')
    <script src="{{ asset('plugins/dataTables/datatables.js') }}"></script>
    <script src="{{ asset('plugins/dataTables/Responsive-2.2.1/js/dataTables.responsive.js') }}"></script>
    <script src="{{ asset('plugins/select2/select2.js') }}"></script>{{-- select2 --}}
@endsection

@section('inline_js')
<script>
    $(document).ready(function(){
        document.title = "BakulVisor | Paket";
        $("#mn-paket").addClass('active');

        //Set for select2
        $('.select2').select2();

        setBarangDetail('1');
    });

    var tpaket = $("#paketTable").DataTable({
        responsive: true,
        processing: true,
        ajax: {
            method: "GET",
            url: "{{ url('list/paket') }}",
        },
        columns: [
            { data: null },
            { data: 'paket_nama' },
            { data: null },
            { data: null },
        ],
        columnDefs: [
            {
                targets: [0],
                searchable: false,
                orderable: false,
            }, {
                targets: [2],
                render: function(data, type, row) {
                    return data.items['barang'];
                }
            }, {
                targets: [3],
                render: function(data, type, row) {
                    var id = data.id;
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
    tpaket.on( 'order.dt search.dt', function () {
        tpaket.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
            cell.innerHTML = i+1;
        } );
    }).draw();
    function generateButton(id){
        var edit = '<a class="btn btn-warning text-white" href="{{ url("staff/paket") }}/'+id+'/edit"><i class="fa fa-edit"></i></a>';

        return "<div class='btn-group'>"+edit+"</div>";
    }

    {{--  Fungsi untuk perhitungan otomatis  --}}
    function hitungHargaPaket(){
        var jumlah = 0;
        var jumlah_asli = 0;
        var harga_item = $('.harga_item').length;

        $(".harga_item").each(function(){
            if (!Number.isNaN(parseInt(this.value, 10))){
                //console.log("Perhitungan dijalankan");
                jumlah += parseInt(this.value, 10);
                $("#input-harga_paket").val(parseInt(jumlah));
            }
        });
        $(".harga_asli").each(function(){
            if (!Number.isNaN(parseInt(this.value, 10))){
                //console.log("Perhitungan dijalankan");
                jumlah_asli += parseInt(this.value, 10);
                $("#input-harga_paket_asli").val(parseInt(jumlah_asli));
            }
        });
    }
    {{--  /.Fungsi untuk perhitungan otomatis  --}}

    {{--  Fungsi untuk Barang  --}}
    function setBarangDetail(item){
        var barang_id = $("#input_"+item+"-barang_id").val();
        console.log("Barang Id : "+barang_id);

        $.ajax({
            method: "GET",
            url: "{{ url('/data/barang/') }}/"+barang_id,
            success: function(result){
                $("#input_"+item+"-harga_asli").val(result.data[0]['barang_hJual']);
                $("#input_"+item+"-harga_item").val(result.data[0]['barang_hJual']);

                hitungHargaPaket();
            }
        });

    }
    {{--  /.Fungsi untuk Barang  --}}

    {{--  Fungsi Add More  --}}
    var awal = 2;
    var akhir = 5; //Max Field
    var add = document.getElementById("addMore");
    var wrap = document.getElementById("paket_wrapper");
    $(add).click(function(e){
        e.preventDefault();
        var konten = parseInt($('.paket_content').length) + 1;

        $('<div class="mb-2 paket_content konten_tambahan" id="content-'+awal+'" style="display:none;"><div class="row">{{-- Paket --}}<div class="col-12 col-lg-6"><div class="form-group" id="field_'+awal+'-barang_id"><label for="input_'+awal+'-barang_id">Kode Barang</label><select name="barang_id[]" class="form-control select2" id="input_'+awal+'-barang_id" onchange="setBarangDetail('+awal+')"> @foreach ($kategori as $item_k) <optgroup label="{{ $item_k['kategori_nama'] }}"> @foreach ($barang as $item_b) @if($item_b['kategori_id'] == $item_k['id']) <option value="{{ $item_b['id'] }}">{{ $item_k['kategori_kode'].'-'.$item_b['barang_kode'].' / '.$item_b['barang_nama'] }}</option> @endif @endforeach </optgroup> @endforeach </select></div></div><div class="col-12 col-lg-3"><div class="form-group" id="field_'+awal+'-harga_asli"><label for="input-harga_asli">Harga@ Asli</label><input type="number" name="harga_asli[]" class="form-control harga_asli" min="0" value="0" id="input_'+awal+'-harga_asli" readonly></div></div><div class="col-12 col-lg-3"><div class="form-group" id="field_'+awal+'-harga_item"><label for="input-harga_item">Harga Item</label><div class="input-group"><input type="number" name="harga_item[]" class="form-control harga_item" min="0" value="0" id="input_'+awal+'-harga_item" onchange="hitungHargaPaket()"><a onclick="removeMore('+awal+')" class="btn text-white btn-danger btnhapus" ><i class="fa fa-trash"></i></a></div></div></div></div>{{-- /.Paket --}}<hr class="my-1"></div>').appendTo($("#paket_wrapper")).slideDown("slow", "swing");

        $('.select2-container').remove();
        $('.select2').select2();
        $(this).find(".select2").prop('selectedIndex', 0).change();
        setBarangDetail(awal);
        awal++;
    });
    function removeMore(id){
        var konten = parseInt($('.paket_content').length) - 1;

        if(confirm('Are you sure you want to delete this element?')) {
            $("#content-"+id).slideUp(function(){
                $(this).remove();
                hitungHargaPaket();
            });
        }
    }

    {{--  Fungsi untuk Paket  --}}
    $("#paketForm").submit(function(e){ //Prevent default Action for Form
        e.preventDefault();
        paketAction();
    });
    function paketAction(){
        $(".error-block").remove();
        $(".form-control").removeClass('has-error');
        $(".input-group-text").removeClass('has-error');

        var formMethod = "POST";
        var url_link = "{{ url('/staff/paket') }}";

        $.ajax({
            method: formMethod,
            url: url_link,
            data: $("#paketForm").serialize(),
            cache: false,
            success: function(result){
                console.log(result);
                topright_notify(result.message);
                $("#paketTable").DataTable().ajax.reload(null, false);

                //ResetForm
                paketSuccess();
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

    $("#paketReset").click(function(e){ //Prevent default Action for Form
        e.preventDefault();
        paketReset();
    });
    function paketReset(){
        if(confirm('Are you sure you want to reset form?')) {
            $(".konten_tambahan").slideUp(function(){
                $(this).remove();
                //Reset perhitungan
                hitungHargaPaket();
            });

            $("#input-paket_nama").val('');

            //Reset item
            $("#input_1-barang_id").prop('selectedIndex', '0').change();
            setBarangDetail('1');
        }
    }
    function paketSuccess(){
        $(".konten_tambahan").slideUp(function(){
            $(this).remove();
            //Reset perhitungan
            hitungHargaPaket();
        });

        $("#input-paket_nama").val('');

        //Reset item
        $("#input_1-barang_id").prop('selectedIndex', '0').change();
        setBarangDetail('1');
    }
    {{--  /.Fungsi untuk Paket  --}}

</script>
@endsection
