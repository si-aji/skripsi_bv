@extends('layouts.staff')

{{--  Require CSS for this Page  --}}
@section('plugin_css')
    <link href="{{ asset('plugins/dataTables/datatables.css') }}" rel="stylesheet">
    <link href="{{ asset('plugins/select2/select2.css') }}" rel="stylesheet">{{-- Select2 --}}
@endsection

{{-- Content Header --}}
@section('staff_content_title')
    <h1 class="m-0 text-dark">Edit - {{ $paket->paket_nama }}</h1>
@endsection
@section('staff_content_breadcrumb')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="{{ url('/staff') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ url('/staff/paket') }}">Paket</a></li>
        <li class="breadcrumb-item active">Edit</li>
    </ol>
@endsection{{-- Content Header --}}

@section('staff_content')
    <div class="card">
        <div class="card-header no-border">
            <h3 class="card-title"><i class="fa fa-suitcase"></i> <span id="span_title">Form Paket (Update)</span></h3>
        </div>
        <form role="form" id="paketForm">
            <div class="card-body">
                <div class="row">
                    <div class="col-12 col-lg-6">{{-- Paket --}}
                        <div class="form-group" id="field-paket_nama">{{-- Nama Paket --}}
                            <label for="input-paket_nama">Nama Paket</label>
                            <input type="hidden" name="id" id="input-paket_id" value="{{ $paket->id }}">
                            <input type="text" name="paket_nama" class="form-control" placeholder="Nama Paket/Kode Paket" id="input-paket_nama" value="{{ $paket->paket_nama }}">
                        </div>{{-- /.Nama Paket --}}
                        <div class="row">
                            <div class="col-12 col-lg-6">
                                <div class="form-group" id="field-harga_paket_asli">{{-- Harga Asli --}}
                                    <label for="input-harga_paket_asli">Harga Asli</label>
                                    <input type="number" name="paket-harga_asli" class="form-control" min="0" value="0" id="input-harga_paket_asli" readonly>
                                </div>{{-- /.Harga Asli --}}
                            </div>
                            <div class="col-12 col-lg-6">
                                <div class="form-group" id="field-harga_paket">{{-- Harga Paket --}}
                                    <label for="input-harga_paket">Harga Paket</label>
                                    <input type="number" name="paket_harga" class="form-control" min="0" value="0" id="input-harga_paket" readonly>
                                </div>{{-- /.Harga Paket --}}
                            </div>
                        </div>
                    </div>{{-- /.Paket --}}

                    <div class="col-12 col-lg-6 mt-4 mt-lg-0">{{-- Paket Item --}}
                        <div id="paket_wrapper">
                        @php $i = 1; @endphp
                        @foreach ($paket->paketItem as $item)
                            <div class="mb-2 paket_content" id="content-{{ $i }}">
                                <div class="row">{{-- Paket Barang --}}
                                    <div class="col-12 col-lg-6">
                                        <div class="form-group" id="field_{{ $i }}-barang_id">
                                            <label for="input_{{ $i }}-barang_id">Kode Barang</label>
                                            <input type="hidden" name="barang_id[]" class="form-control" id="input_{{ $i }}-barang_id" value="{{ $item->barang_id }}" readonly>
                                            <input type="text" name="barang_nama[]" class="form-control" id="input_{{ $i }}-barang_nama" value="{{ ucwords($item->barang->barang_nama) }}" readonly>
                                        </div>
                                    </div>

                                    <div class="col-12 col-lg-3">{{-- Harga @Asli --}}
                                        <div class="form-group" id="field_{{ $i }}-harga_asli">
                                            <label for="input_{{ $i }}-harga_asli">Harga@ Asli</label>
                                            <input type="number" name="harga_asli[]" class="form-control harga_asli" id="field_{{ $i }}-harga_asli" value="{{ $item->barang_hAsli }}" readonly>
                                        </div>
                                    </div>{{-- /.Harga @Asli --}}
                                    <div class="col-12 col-lg-3">{{-- Harga Item --}}
                                        <div class="form-group" id="field_{{ $i }}-harga_item">
                                            <label for="input_{{ $i }}-harga_item">Harga Item</label>
                                            <div class="input-group">
                                                <input type="number" name="harga_item[]" class="form-control harga_item" id="field_{{ $i }}-harga_item" value="{{ $item->barang_hJual }}" onchange="hitungHargaPaket()">
                                                <a onclick="hapus_item('{{ $i }}')" class="btn text-white btn-danger btnhapus" ><i class="fa fa-trash"></i></a>
                                            </div>
                                        </div>
                                    </div>{{-- /.Harga @Asli --}}
                                </div>{{-- /.Paket Barang --}}
                                <hr class="my-1">
                            </div>
                            @php $i++; @endphp
                        @endforeach
                        </div>
                        <a class="btn btn-info btn-sm icon-btn mb-2 text-white" id="addMore">
                            <i class="mdi mdi-plus"></i> Add new Row
                        </a>
                    </div>{{-- Paket Item --}}
                </div>
            </div>

            <div class="card-footer">
                <div class="form-group text-right">
                    <button type="reset" id="paketReset" class="btn btn-danger text-white">Reset</button>
                    <button type="submit" class="btn btn-primary text-white">Submit</button>
                </div>
            </div>
        </form>
    </div>
@endsection

{{--  Require Js for this page  --}}
@section('plugins_js')
    <script src="{{ asset('plugins/dataTables/datatables.js') }}"></script>
    <script src="{{ asset('plugins/dataTables/Responsive-2.2.1/js/datatables.responsive.js') }}"></script>
    <script src="{{ asset('plugins/select2/select2.js') }}"></script>{{-- select2 --}}
@endsection

@section('inline_js')
<script>
    $(document).ready(function(){
        document.title = "BakulVisor | Edit Paket";
        $("#mn-paket").addClass('active');

        //Set for select2
        $('.select2').select2();

        hitungHargaPaket();
    });

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

    {{--  Fungsi untuk Item  --}}
    var awal = {{ $i }};
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

    function hapus_item(id){
        var paket_id = $("#input-paket_id").val();
        var barang_id = $("#input_"+id+"-barang_id").val();

        console.log("Hapus Barang : "+barang_id+" pada paket : "+paket_id);
        swal({
            title: "Warning!",
            text: "Are you sure want to delete this item? this action cannot be undo!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        }).then((value) => {
            //console.log(value);
            if(value == true){
                var formMethod = "PUT";
                var url_link = "{{ url('/staff/paket').'/'.$paket->id }}";

                $.ajax({
                    method: formMethod,
                    url: url_link,
                    data: {'permintaan': 'hapus_item', 'paket_id': paket_id, 'barang_id': barang_id},
                    cache: false,
                    success: function(result){
                        $("#content-"+id).slideUp(function(){
                            $(this).remove();
                        });

                        swal({
                            title: "Success!",
                            text: "Redirect to Paket page?",
                            icon: "success",
                            buttons: true,
                            dangerMode: true,
                        }).then((value) => {
                            if(value == true){
                                showSuccess_redirect('You will be redirected in a few seconds', "{{ url('/staff/paket') }}");
                            }
                        });
                    }
                });
            }
        });
    }
    {{--  /.Fungsi untuk Item  --}}

    {{--  Fungsi untuk Paket  --}}
    $("#paketForm").submit(function(e){ //Prevent default Action for Form
        e.preventDefault();
        paketAction();
    });
    function paketAction(){
        $(".error-block").remove();
        $(".form-control").removeClass('has-error');
        $(".input-group-text").removeClass('has-error');

        var formMethod = "PUT";
        var url_link = "{{ url('/staff/paket').'/'.$paket->id }}";

        $.ajax({
            method: formMethod,
            url: url_link,
            data: $("#paketForm").serialize(),
            cache: false,
            success: function(result){
                console.log(result);

                showSuccess_redirect(result.message, "{{ url('/staff/paket') }}");
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
    {{--  Fungsi untuk Paket  --}}
</script>
@endsection
