@extends('layouts.staff')

{{-- Content Header --}}
@section('staff_content_title')
    <h1 class="m-0 text-dark">Invoice Penjualan</h1>
@endsection
@section('staff_content_breadcrumb')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="{{ url('/staff') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ url('/penjualan') }}">Penjualan</a></li>
        <li class="breadcrumb-item active">Invoice Penjualan</li>
    </ol>
@endsection{{-- Content Header --}}

@section('staff_content')
<div class="card">
    <div class="card-header no-border">
        <h3 class="card-title">
            <i class="fa fa-globe"></i> <span id="span_title">{{ '#'.$penjualan->penjualan_invoice }}</span>
            <span class="pull-right hidden-lg-down"><small>{{ formated_date(now()) }}</small></span>
        </h3>
    </div>
    <div class="card-body">
        <div class="row mb-3">
            <div class="col-12 col-md-6">{{-- Informasi Toko --}}
                <div class="form-group">
                    <label class="mb-0">Toko</label>
                    <br><span>{{ $penjualan->toko->toko_nama." (".$penjualan->toko->toko_tipe.")" }}</span>
                </div>

                @if($penjualan->toko->toko_kontak != null)
                <div class="form-group">
                    <label class="mb-0">Kontak</label>
                    <br><span>{{ $penjualan->toko->toko_kontak }}</span>
                </div>
                @endif

                @if($penjualan->toko->toko_alamat != null)
                <div class="form-group">
                    <label class="mb-0">Alamat</label>
                    <br><span>{{ $penjualan->toko->toko_alamat }}</span>
                </div>
                @endif

                <div class="form-group">
                    <label class="mb-0">Tanggal Transaksi</label>
                    <br><span>{{ formated_date($penjualan->penjualan_tgl) }}</span>
                </div>
            </div>{{-- /.Informasi Toko --}}

            @if($penjualan->kostumer != null)
            <div class="col-12 col-md-6">{{-- Informasi Kostumer (Jika ada) --}}
                <div class="form-group">
                    <label class="mb-0">Kostumer</label>
                    <br><span>{{ $penjualan->kostumer->kostumer_nama }}</span>
                </div>

                @if($penjualan->kostumer->kostumer_kontak != null)
                <div class="form-group">
                    <label class="mb-0">Kontak</label>
                    <br><span>{{ $penjualan->kostumer->kostumer_kontak }}</span>
                </div>
                @endif

                @if($penjualan->kostumer->kostumer_detail != null)
                <div class="form-group">
                    <label class="mb-0">Detail</label>
                    <br><span>{{ $penjualan->kostumer->kostumer_detail }}</span>
                </div>
                @endif
            </div>{{-- /.Informasi Kostumer (Jika ada) --}}
            @endif
        </div>

        <div class="row">
            <div class="col-12 table-responsive">
                <table class="table table-hover table-striped w-100">
                    <thead>
                        <tr>
                            <th>Nama Barang</th>
                            <th>Harga @</th>
                            <th>Qty</th>
                            <th>Diskon</th>
                            <th>Sub Total</th>
                        </tr>
                    </thead>
                    <tbody>
                    @if($penjualan->penjualanDetail != null)
                    @php
                    $total = 0;
                    @endphp
                        @foreach ($penjualan->penjualanDetail as $item)
                            @php
                                $subtotal = ($item->harga_jual * $item->jual_qty) - $item->diskon;
                                $total = $total + $subtotal;
                            @endphp

                        <tr>
                            <td>{{ $item->barang->barang_nama }}</td>
                            <td>{{ idr_currency($item->harga_jual) }}</td>
                            <td>{{ $item->jual_qty }}</td>
                            <td>{{ idr_currency($item->diskon) }}</td>
                            <td>{{ idr_currency($subtotal) }}</td>
                        </tr>
                        @endforeach
                        <tr class="nominalSub">
                            <td class="text-right" colspan="4">Jumlah</td>
                            <td>{{ idr_currency($total) }}</td>
                        </tr>

                        @php
                            $biayaLain = 0;
                            $bayar = 0;
                        @endphp
                        @foreach ($penjualan->penjualanLog as $log)
                            @php
                                $biayaLain = $biayaLain + $log->biaya_lain;
                                $bayar = $bayar + $log->bayar;
                            @endphp
                        @endforeach

                        @php
                            $kekurangan = ($total + $biayaLain) - $bayar;
                        @endphp
                        <tr class="nominalSub">
                            <td class="text-right" colspan="4">Biaya Lain</td>
                            <td>{{ idr_currency($biayaLain) }}</td>
                        </tr>
                        <tr class="nominalResult">
                            <td class="text-right" colspan="4">Total</td>
                            <td>{{ idr_currency($total + $biayaLain) }}</td>
                        </tr>
                        <tr class="nominalResult">
                            <td class="text-right" colspan="4">Bayar</td>
                            <td>{{ idr_currency($bayar) }}</td>
                        </tr>
                        <tr class="nominalResult">
                            <td class="text-right" colspan="4">Kekurangan</td>
                            <td>{{ idr_currency($kekurangan) }}</td>
                        </tr>
                    @else
                    @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="card-footer">
        <div class="btn-group">
            <a href="{{ url('/staff/penjualan') }}" class="btn text-white btn-primary"><i class="fa fa-arrow-left"></i> Kembali</a>
            <a href="{{ url('/staff/penjualan') }}/{{ str_replace('/', '-', $penjualan->penjualan_invoice).'/edit' }}" class="btn text-white btn-warning"><i class="fa fa-edit"></i> Edit</a>
            <a onclick="formDelete('{{ $penjualan->id }}')" class="btn text-white btn-danger"><i class="fa fa-trash"></i> Hapus</a>
        </div>
    </div>
</div>
@endsection

@section('inline_js')
<script>
    $(document).ready(function(){
        document.title = "BakulVisor | Invoice Penjualan";
        $("#mn-penjualan").closest('li').addClass('menu-open');
        $("#mn-penjualan").addClass('active');
        $("#sub-penjualan_list").addClass('active');
    });

    //Delete
    function formDelete(id){
        var penjualan_id = id;
        var url_link = '{{ url('staff/penjualan') }}/'+penjualan_id;

        swal({
            title: "Warning!",
            text: "This data will be deleted. All data related to this transaction will be deleted, this action cannot be undo! Please type 'delete' to start process!",
            icon: "warning",
            buttons: true,
            content: "input",
            dangerMode: true,
        }).then((value) => {
            if (value == "delete") {
                $.ajax({
                    method: 'POST',
                    url: url_link,
                    data: {'_method': 'delete'},
                    cache: false,
                    success: function(result){
                        console.log(result);

                        //Redirect
                        showSuccess_redirect(result.message, "{{ url('/staff/penjualan') }}");
                    },
                    error: function( jqXHR, textStatus, errorThrown ) {
                        console.log(jqXHR);
                    }
                });
            } else {
                swal({
                    icon: "error",
                    title: "Failed!",
                    text: "Invalid, please try again. Please type 'delete' to start the process.",
                });
            }
        });
    }
</script>
@endsection
