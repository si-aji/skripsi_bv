@extends('layouts.staff')

{{-- Content Header --}}
@section('staff_content_title')
    <h1 class="m-0 text-dark">Invoice Pembelian</h1>
@endsection
@section('staff_content_breadcrumb')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="{{ url('/staff') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ url('/pembelian') }}">Pembelian</a></li>
        <li class="breadcrumb-item active">Invoice Pembelian</li>
    </ol>
@endsection{{-- Content Header --}}

@section('staff_content')
<div class="card">
    <div class="card-header no-border">
        <h3 class="card-title">
            <i class="fa fa-globe"></i> <span id="span_title">{{ '#'.$pembelian->pembelian_invoice }}</span>
            <span class="pull-right hidden-lg-down"><small>{{ formated_date(now()) }}</small></span>
        </h3>
    </div>

    <div class="card-body">
        <div class="row mb-3">
            <div class="col-12 col-md-6">{{-- Informasi Supplier --}}
                <div class="form-group">
                    <label class="mb-0">Suppler</label>
                    <br><span>{{ $pembelian->supplier->supplier_nama }}</span>
                </div>

                @if($pembelian->supplier->supplier_kontak != null)
                <div class="form-group">
                    <label class="mb-0">Kontak</label>
                    <br><span>{{ $pembelian->supplier->supplier_kontak }}</span>
                </div>
                @endif

                @if($pembelian->supplier->supplier_detail != null)
                <div class="form-group">
                    <label class="mb-0">Detail</label>
                    <br><span>{{ $pembelian->supplier->supplier_detail }}</span>
                </div>
                @endif

                <div class="form-group">
                    <label class="mb-0">Tanggal Transaksi</label>
                    <br><span>{{ formated_date($pembelian->pembelian_tgl) }}</span>
                </div>
            </div>{{-- /.Informasi Supplier --}}

            <div class="col-12 col-md-6">{{-- Informasi Transaksi --}}
                <div class="form-group">
                    <label class="mb-0">Tanggal Transaksi</label>
                    <br><span>{{ formated_date($pembelian->pembelian_tgl) }}</span>
                </div>

                <div class="form-group">
                    <label class="mb-0">Tanggal Dibuat</label>
                    <br><span>{{ $pembelian->created_at }}</span>
                </div>

                <div class="form-group">
                    <label class="mb-0">Tanggal Diperbaharui</label>
                    <br><span>{{ $pembelian->updated_at }}</span>
                </div>

                @if($pembelian->pembelian_detail != '<p>&nbsp;</p>')
                <div class="form-group">
                    <label class="mb-0">Catatan</label>
                    <br>
                    <div class="card">
                        <div class="card-body">
                            {!! $pembelian->pembelian_detail !!}
                        </div>
                    </div>
                </div>
                @endif
            </div>{{-- Informasi Transaksi --}}
        </div>

        <div class="row">
            <div class="col-12 table-responsive">
                <table class="table table-hover table-striped w-100">
                    <thead>
                        <tr>
                            <th>Nama Barang</th>
                            <th>Harga @</th>
                            <th>Qty</th>
                            <th>Sub Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($pembelian->pembelianItem != null)
                        @php
                        $total = 0;
                        $subtotal = 0;
                        @endphp
                            @foreach ($pembelian->pembelianItem as $item)
                                @php
                                    $subtotal = ($item->harga_beli * $item->beli_qty);
                                    $total = $total + $subtotal;
                                @endphp

                            <tr>
                                <td>{{ $item->barang->barang_nama }}</td>
                                <td>{{ idr_currency($item->harga_beli) }}</td>
                                <td>{{ $item->beli_qty }}</td>
                                <td>{{ idr_currency($subtotal) }}</td>
                            </tr>
                            @endforeach
                            <tr class="nominalSub">
                                <td class="text-right" colspan="3">Jumlah</td>
                                <td>{{ idr_currency($total) }}</td>
                            </tr>

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

                            @php
                                $kekurangan = (($total + $biayaLain) - $diskon) - $bayar;
                            @endphp
                            <tr class="nominalSub">
                                <td class="text-right" colspan="3">Biaya Lain</td>
                                <td>{{ idr_currency($biayaLain) }}</td>
                            </tr>
                            <tr class="nominalSub">
                                <td class="text-right" colspan="3">Diskon</td>
                                <td>{{ idr_currency($diskon) }}</td>
                            </tr>
                            <tr class="nominalResult">
                                <td class="text-right" colspan="3">Total</td>
                                <td>{{ idr_currency(($total + $biayaLain) - $diskon) }}</td>
                            </tr>
                            <tr class="nominalResult">
                                <td class="text-right" colspan="3">Bayar</td>
                                <td>{{ idr_currency($bayar) }}</td>
                            </tr>
                            <tr class="nominalResult">
                                <td class="text-right" colspan="3">Kekurangan</td>
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
            <a href="{{ url('/staff/pembelian') }}" class="btn text-white btn-primary"><i class="fa fa-arrow-left"></i> Kembali</a>
            <a href="{{ url('/staff/pembelian') }}/{{ str_replace('/', '-', $pembelian->pembelian_invoice).'/edit' }}" class="btn text-white btn-warning"><i class="fa fa-edit"></i> Edit</a>
            <a onclick="formDelete('{{ $pembelian->id }}')" class="btn text-white btn-danger"><i class="fa fa-trash"></i> Hapus</a>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Histori Pembayaran</h3>
    </div>
    <div class="card-body">
        <ul class="timeline timeline-inverse">
            @php
                $bg = array("bg-primary", "bg-danger", "bg-warning", "bg-success", "bg-info");
                $tanggal = "";

                $biayaLain = 0;
                $diskon = 0;
                $bayar = 0;
                $kekurangan = 0;
            @endphp
            @foreach ($pembelian->pembelianBayar as $log)
                @php
                    $biayaLain = $biayaLain + $log->biaya_lain;
                    $diskon = $diskon + $log->diskon;
                    $bayar = $bayar + $log->bayar;

                    $kekurangan = (($total + $biayaLain) - $diskon) - $bayar;
                @endphp
                @if(only_date($log->pembayaran_tgl) != $tanggal)
                <!-- Time Label -->
                <li class="time-label">
                    <span class="{{ $bg[array_rand($bg)] }} text-white">
                        {{ only_date($log->pembayaran_tgl) }}
                    </span>
                </li><!-- /.Time Label -->
                @endif

            <!-- Timeline Item -->
            <li>
                <i class="fa fa-clock-o {{ $bg[array_rand($bg)] }}"></i>
                <div class="timeline-item">
                    <span class="time"><i class="fa fa-clock-o"></i> {{ formated_date($log->pembayaran_tgl) }}</span>
                    <h3 class="timeline-header"><a href="#">{{ $log->user->name }}</a></h3>
                    <div class="timeline-body">

                        @if($log->biaya_lain == 0)
                        @php
                            $tandaBiayaLain = 'fa-caret-left';
                            $warnaBiayaLain = 'text-warning';
                        @endphp
                        @elseif($log->biaya_lain < 0)
                        @php
                            $tandaBiayaLain = 'fa-caret-down';
                            $warnaBiayaLain = 'text-danger';
                        @endphp
                        @else
                        @php
                            $tandaBiayaLain = 'fa-caret-up';
                            $warnaBiayaLain = 'text-success';
                        @endphp
                        @endif

                        @if($log->diskon == 0)
                        @php
                            $tandaDiskon = 'fa-caret-left';
                            $warnaDiskon = 'text-warning';
                        @endphp
                        @elseif($log->diskon < 0)
                        @php
                            $tandaDiskon = 'fa-caret-down';
                            $warnaDiskon = 'text-danger';
                        @endphp
                        @else
                        @php
                            $tandaDiskon = 'fa-caret-up';
                            $warnaDiskon = 'text-success';
                        @endphp
                        @endif

                        @if($log->bayar == 0)
                        @php
                            $tandaBayar = 'fa-caret-left';
                            $warnaBayar = 'text-warning';
                        @endphp
                        @elseif($log->bayar < 0)
                        @php
                            $tandaBayar = 'fa-caret-down';
                            $warnaBayar = 'text-danger';
                        @endphp
                        @else
                        @php
                            $tandaBayar = 'fa-caret-up';
                            $warnaBayar = 'text-success';
                        @endphp
                        @endif

                        <div class="row">
                            <div class="col-12 col-md-6 col-lg-3">
                                <div class="description-block border-right">
                                    <span class="description-percentage {{ $warnaBiayaLain }}"><i class="fa {{ $tandaBiayaLain }}"></i> {{ idr_currency($log->biaya_lain) }}</span>
                                    <h5 class="description-header">{{ idr_currency($biayaLain) }}</h5>
                                    <span class="description-text">BIAYA LAIN</span>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-3">
                                <div class="description-block border-right">
                                    <span class="description-percentage {{ $warnaDiskon }}"><i class="fa {{ $tandaDiskon }}"></i> {{ idr_currency($log->diskon) }}</span>
                                    <h5 class="description-header">{{ idr_currency($diskon) }}</h5>
                                    <span class="description-text">DISKON</span>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-3">
                                <div class="description-block border-right">
                                    <span class="description-percentage {{ $warnaBayar }}"><i class="fa {{ $tandaBayar }}"></i> {{ idr_currency($log->bayar) }}</span>
                                    <h5 class="description-header">{{ idr_currency($bayar) }}</h5>
                                    <span class="description-text">BAYAR</span>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-3">
                                <div class="description-block">
                                    <h5 class="description-header">{{ idr_currency($kekurangan) }}</h5>
                                    <span class="description-text">KEKURANGAN</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </li><!-- /.Timeline Item -->
            @php
                $tanggal = only_date($log->pembayaran_tgl);
            @endphp
            @endforeach
            <li>
                <i class="fa fa-clock-o bg-gray"></i>
            </li>
        </ul>
    </div>
</div>
@endsection

@section('inline_js')
<script>
    $(document).ready(function(){
        document.title = "BakulVisor | Invoice Pembelian";
        $("#mn-pembelian").closest('li').addClass('menu-open');
        $("#mn-pembelian").addClass('active');
        $("#sub-pembelian_list").addClass('active');
    });

    //Delete
    function formDelete(id){
        var pembelian_id = id;
        var url_link = '{{ url('staff/pembelian') }}/'+pembelian_id;

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
                        showSuccess_redirect(result.message, "{{ url('/staff/pembelian') }}");
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
